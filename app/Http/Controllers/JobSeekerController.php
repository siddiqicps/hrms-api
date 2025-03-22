<?php

namespace App\Http\Controllers;

use App\Models\JobSeeker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\DB;

class JobSeekerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function getAllJobseekers(Request $request){
        $query = DB::table('jobseeker_info')
                        ->leftJoin('applied_jobs','jobseeker_info.jobseeker_id', '=', 'applied_jobs.jobseeker_id')
                        // ->leftJoin('applied_jobs', function($join){
                        //     $join->on('jobseeker_info.jobseeker_id', '=', 'applied_jobs.jobseeker_id')
                        //         ->orderByDesc('applied_jobs.jobseeker_id')->take(1);
                        // });
                        ->leftJoin('post_info', 'applied_jobs.post_id','=','post_info.post_id')
                        ->select('jobseeker_info.*','post_info.post_title');
        if($request->get("name") && $request->get("name") != ""){
            $query = $query->where("name", 'like', '%'.$request->get("name").'%');
        }

        if($request->get("phone") && $request->get("phone") != ""){
            $query = $query->where("phone_number", 'like', '%'.$request->get("phone").'%');
        }

        if($request->get("email") && $request->get("email") != ""){
            $query = $query->where("email_id",'like', '%'.$request->get("email").'%');
        }

        if($request->get("post") && $request->get("post") != ""){
            $query = $query->where("post_info.post_title",'like', '%'.$request->get("post").'%');
        }

        if($request->get("branch") && $request->get("branch") != ""){
            $query = $query->where("jobseeker_info.branch_id",'=', $request->get("branch"));
        }

        // ->orWhere("email_id", $request->get("filter"))
                        // ->orWhere("phone_number", $request->get("filter"))
                        // ->orWhere("qualification", $request->get("filter"));
            $query = $query->orderByDesc("jobseeker_id")->paginate(15);
        return response()->json($query);
    }

    public function getJobseeker($id){
        return response()->json(JobSeeker::find($id));
    }

    public function getDocument(Request $request){
        $reqPayload = $request->all();
        $jobseeker = JobSeeker::find($reqPayload["id"]);
        // $file = $reqPayload["doc_type"] == "resume" ? $jobseeker->resume : $jobseeker->certificate;
        // $resume = base_path().'/public/client_logos/'.$jobseeker->resume;
        $resume = base_path().'../resumes/'.$jobseeker->resume;
        // $cert = $jobseeker->certificate ? base_path().'/public/client_logos/'.$jobseeker->certificate : null;
        $cert = $jobseeker->certificate ? base_path().'../certificates/'.$jobseeker->certificate : null;
        $type_resume = pathinfo($resume, PATHINFO_EXTENSION);
        $data_resume = file_get_contents($resume);
        $base64_resume  = 'data:application/' . $type_resume . ';base64,' . base64_encode($data_resume);
        $base64_cert = null;
        if($cert != null){
            $type_cert = pathinfo($cert, PATHINFO_EXTENSION);
            $data_cert = file_get_contents($cert);
            $base64_cert  = 'data:application/' . $type_cert . ';base64,' . base64_encode($data_cert);
        }
        return response()->json(["resume" => $base64_resume, "certificate" => $base64_cert]);
    }

    public function addJobseeker(Request $request) : JsonResponse {
        $reqPayload = $request->all();
        $getJobseekerDetails = JobSeeker::where("email_id", $reqPayload["email_id"])
                                    // ->orWhere("phone_number", $reqPayload["phone_number"])
                                    ->first();
        if($getJobseekerDetails){
            return response()->json(["msg"=>"You are already registerd with this email id or contact number. Please access your profile to update.","icon"=>"warning", "title"=>"Oops..."], Response::HTTP_CREATED);
        }
        $cv_file_name = $this->createFile($reqPayload["resume"]);
        $reqPayload["resume"] = $cv_file_name;
        if($cv_file_name){
            $reqPayload["isUploaded"] = 1;
        }
        $cert_file_name = $this->createFile($reqPayload["certificate"]);
        $reqPayload["certificate"] = $cert_file_name;
        $reqPayload["isDeleted"] = 0;
        $job_seeker = JobSeeker::create($reqPayload);

        $msg = "Your are successfully registered.";

        if($reqPayload["post_id"]){
            $applied_job = DB::table('applied_jobs')
                                ->insert([["post_id" => $reqPayload["post_id"], "jobseeker_id" => $job_seeker->jobseeker_id, "added_date" => date("Y-m-d H:i:s")]]);
            $msg = "Your have successfully applied for the job";
        }

        $this->sendSuccessEmail($reqPayload);
        return response()->json(["msg"=> $msg,"icon"=>"success", "title"=>"Done!", "data"=>$job_seeker], Response::HTTP_CREATED);
    }

    public function updateJobseeker($id, Request $request) : JsonResponse {
        $reqPayload = $request->all();
        $job_seeker = JobSeeker::findOrFail($id);
        $cv_file_name = $this->createFile($reqPayload["resume"]);
        if($cv_file_name && $cv_file_name!=""){
            $reqPayload["resume"] = $cv_file_name;
            $reqPayload["isUploaded"] = 1;
        }else{
            unset($reqPayload["resume"]);
        }
        $cert_file_name = $this->createFile($reqPayload["certificate"]);
        if($cert_file_name && $cert_file_name!=""){
            $reqPayload["certificate"] = $cert_file_name;
        }else{
            unset($reqPayload["certificate"]);
        }
        $reqPayload["isDeleted"] = 0;
        $job_seeker->update($reqPayload);

        $msg = "Your profile is successfully updated.";

        if($reqPayload["post_id"]){
            $applied_job = DB::table('applied_jobs')
                                ->insert([["post_id" => $reqPayload["post_id"], "jobseeker_id" => $id, "added_date" => date("Y-m-d H:i:s")]]);
            $msg = "Your have successfully applied for the job";
            $this->sendSuccessEmail($reqPayload);
        }
        
        
        return response()->json(["msg"=> $msg,"icon"=>"success", "title"=>"Done!", "data"=>$job_seeker], Response::HTTP_OK);
    }

    public function deleteJobseeker($id) : JsonResponse {
        $job_seeker = JobSeeker::findOrFail($id);
        $job_seeker_name = $job_seeker->name;
        $job_seeker->delete();
        return response()->json("JobSeeker `".$job_seeker_name."` deleted successfully");
    }

    public function createFile($dataUri) {
        $file_name = '';
        try{
            if($dataUri && $dataUri != ""){
                list($mime, $data) = explode(';', $dataUri);
                list(,$data) = explode(',', $data);
                $data = base64_decode($data);
                $ext = '.png';
                if($mime == "data:image/png"){
                    $ext = '.png';
                }
                if($mime == "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                    $ext = ".docx";
                }
                if($mime == "data:application/pdf"){
                    $ext = ".pdf";
                }
                $file_name = mt_rand().time().$ext;
                // $path = base_path().'/public/client_logos/';
                $path = base_path().'../resume/';
                file_put_contents($path.$file_name, $data);
            }
            return $file_name;
        } catch(\Exception $e){
            return($e);
        }
    }

    public function sendOTP(Request $request) : JsonResponse {
        $reqPayload = $request->all();
        $getJobseekerDetails = JobSeeker::where("email_id", $reqPayload["email_id"])
                                    // ->orWhere("phone_number", $reqPayload["phone_number"])
                                    ->first();
        $to_name = $getJobseekerDetails->name;
        $to_email = $getJobseekerDetails->email_id;
        $otp = $this->generateNumericOTP(4);
        $data = array("name"=>$to_name, "otp" => $otp, "body" => "Solar HRM");
        DB::table('jobseeker_info')
              ->where('email_id', $reqPayload["email_id"])
              ->update(['otp' => $otp]);

        Mail::send("emails.otp-mail", $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject("OTP Solar HRM Profile Access");
            // $message->from("testingtesterfoo@gmail.com","Solar HRM");

        });
        return response()->json(["msg"=>"OTP send successfully ","icon"=>"success", "title"=>"Done"], Response::HTTP_OK);
    }

    public function verifyOTP(Request $request) : JsonResponse {
        $reqPayload = $request->all();
        $getJobseekerDetails = JobSeeker::where("otp", $reqPayload["otp"])
                                    ->first();
        if(!$getJobseekerDetails){
            return response()->json(["msg"=>"You have entered invalid OTP.","icon"=>"error", "title"=>"Error"], Response::HTTP_OK);
        }
        return response()->json($getJobseekerDetails, Response::HTTP_OK);
    }

    // Function to generate OTP
    public function generateNumericOTP($n) {
          
        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";
      
        // Iterate for n-times and pick a single character
        // from generator and append it to $result
          
        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result
      
        $result = "";
      
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
      
        // Return result
        return $result;
    }

    public function sendSuccessEmail($payload) {
        $email_template = "emails.registered-success";
        $job_title = "";
        $emailSubject = "Thanks for registering with Solar HRM";
        if($payload["post_id"] && $payload["post_id"] != ""){
            $getJobDetails = DB::table('post_info')->where("post_id", $payload["post_id"])
                                    // ->orWhere("phone_number", $reqPayload["phone_number"])
                                    ->first();
            $job_title = $getJobDetails->post_title;
            $email_template = "emails.applied-succeshaves";
            $emailSubject = "You Applied for ".$job_title;
        }
        $to_name = $payload["name"];
        $to_email = $payload["email_id"];
        
        $data = array("name"=>$to_name, "post_title" => $job_title, "body" => "Solar HRM");

        
        Mail::send($email_template, $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject("OTP Solar HRM Profile Access");
            // $message->from("testingtesterfoo@gmail.com","Solar HRM");

        });
        // return response()->json(["msg"=>"OTP send successfully ","icon"=>"success", "title"=>"Done"], Response::HTTP_OK);
    }
}

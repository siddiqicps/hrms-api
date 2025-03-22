<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
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

    public function getAllJobs() : JsonResponse {
        $query = DB::table("post_info as post")
                    ->join("clients_info as client", "client.client_id", "=", "post.client_id")
                    ->select(["post.added_date", "client.client_id", "client.client_logo", "client.client_name",
                    "client.client_profile", "client.client_status", "client.client_testimonial",
                    "post.client_visibility", "post.deleted_at", "post.isDeleted", "post.modified_date",
                    "post.post_description", "post.post_expiry_date", "post.post_id",
                    "post.post_location", "post.post_status", "post.post_title", "post.profile_details",
                    "post.walkin_date", "post.walkin_location", "post.walkin_visibility"])
                    ->orderByDesc("post_id")
                    ->paginate(15);
        return response()->json($query);
    }

    public function getAllJobsFront(Request $request) : JsonResponse {
        $query = DB::table("post_info")
                    ->join("clients_info", "clients_info.client_id", "=", "post_info.client_id")
                    ->where("post_info.post_status", "Active");
        // if($request->get("category") && $request->get("category") != ""){
        //     $query->where("designation",$request->get("category"));
        // }
        if($request->get("location") && $request->get("location") != ""){
            $query = $query->where("post_info.post_location",$request->get("location"));
        }
        $query = $query->paginate(15);
        // dd($query->toSql());
        return response()->json($query);
    }

    public function getJob($id) : JsonResponse {
        $query = DB::table("post_info")
        ->join("clients_info", "clients_info.client_id", "=", "post_info.client_id")
        ->where("post_info.post_status", "Active")
        ->where("post_info.post_id","=", $id)
        ->get();
        return response()->json($query);
    }

    public function addJob(Request $request) : JsonResponse {
        $payload = $request->all();
        $payload["post_expiry_date"] = date('Y-m-d', strtotime($payload["post_date"]. ' + 2 months'));
        $job = Job::create($payload);
        return response()->json($job, Response::HTTP_CREATED);
    }

    public function updateJob($id, Request $request) : JsonResponse {
        $job = Job::findOrFail($id);
        $job->update($request->all());
        return response()->json($job, Response::HTTP_OK);
    }

    public function deleteJob($id) : JsonResponse {
        $job = Job::findOrFail($id);
        $job_title = $job->post_title;
        $job->delete();
        return response()->json("Job `".$job_title."` deleted successfully", Response::HTTP_OK);
    }

    public function getDashboardJobs() : JsonResponse {
        $query = DB::table("post_info")
                        ->select(DB::raw('COUNT(IF(post_status="Active", 1, NULL)) AS active_posts, COUNT(IF(post_status="Closed", 1, NULL)) AS close_posts, COUNT(post_id) AS posts'))
                        ->get();
        return response()->json($query);
    }

    public function getDashboardClientsJobs() : JsonResponse {
        $query = DB::table("post_info")
                        ->join("clients_info", "clients_info.client_id", "=", "post_info.client_id")
                        ->select(DB::raw('COUNT(post_id) AS posts, clients_info.client_name as client'))
                        ->groupBy('clients_info.client_name')
                        ->orderByDesc('posts')
                        ->take(10)
                        ->get();
        return response()->json($query);
    }
}

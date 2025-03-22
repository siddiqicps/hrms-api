<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class BranchController extends Controller
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

    public function getAllBranches() : JsonResponse {
        return response()->json(Branch::orderBy('branch_id')->get());
    }

    public function getBranch($id) : JsonResponse {
        return response()->json(Branch::find($id));
    }

    public function addBranch(Request $request) : JsonResponse {
        // return response()->json($request->all()["branch"],201);
        $branch = Branch::create($request->all());
        return response()->json($branch, Response::HTTP_CREATED);
    }

    public function updateBranch($id, Request $request) : JsonResponse {
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());
        return response()->json($branch, Response::HTTP_OK);
    }

    public function deleteBranch($id) : JsonResponse{
        $branch = Branch::findOrFail($id);
        $branch_name = $branch->name;
        $branch->delete();
        return response()->json("Branch `".$branch_name."` deleted successfully", Response::HTTP_OK);
    }

    public function getAllFormData() : JsonResponse{
        $formData["branches"] = $this->getBranches();
        $formData["designations"] = $this->getAllDesignations();
        $formData["countries"] = $this->getAllCountries();
        $formData["qualifications"] = $this->getAllQualifications();
        return response()->json($formData, Response::HTTP_OK);
    }

    public function getBranches(){
        return Branch::orderBy('branch_id')->pluck('name','branch_id');
    }

    public function getAllDesignations() {
        $designations = ["Real Estate Manager"=>'Real Estate Manager',"Real Estate Executive"=>'Real Estate Executive',"AC Technician"=>'AC Technician',"AC Compressor Mechanic"=>'AC Compressor Mechanic',"HVAC Chiller Technician"=>'HVAC Chiller Technician',"Plumber"=>'Plumber',"Nurse Male"=>'Nurse Male',"Nurse Female"=>'Nurse Female',"Care Worker Male"=>'Care Worker Male',"Care Worker Female"=>'Care Worker Female',"Waiters"=>'Waiters',"Waitress"=>'Waitress',"Kitchen Helpers"=>'Kitchen Helpers',"Auxiliary Warehouse Worker"=>'Auxiliary Warehouse Worker',"Sales Man"=>'Sales Man',"Sales Lady"=>'Sales Lady',"Western Cook"=>'Western Cook',"Store Keeper"=>'Store Keeper',"Industrial Technician"=>'Industrial Technician',"Reinforcing Ironworker"=>'Reinforcing Ironworker',"Pipe Fitter"=>'Pipe Fitter',"Bricklayer"=>'Bricklayer',"Carpenter"=>'Carpenter',"Mason"=>'Mason',"HVAC Technician"=>'HVAC Technician',"Electrician"=>'Electrician',"6G Welders"=>'6G Welders',"Fabricators"=>'Fabricators'];
        return $designations;
    }

    public function getAllCountries(){
        $country_list = array(
            'United States'    =>  'United States',
            'Afghanistan'    =>  'Afghanistan',
            'Albania'    =>  'Albania',
            'Algeria'    =>  'Algeria',
            'American Samoa'    =>  'American Samoa',
            'Andorra'    =>  'Andorra',
            'Angola'    =>  'Angola',
            'Anguilla'    =>  'Anguilla',
            'Antarctica'    =>  'Antarctica',
            'Antigua And Barbuda'    =>  'Antigua And Barbuda',
            'Argentina'    =>  'Argentina',
            'Armenia'    =>  'Armenia',
            'Aruba'    =>  'Aruba',
            'Australia'    =>  'Australia',
            'Austria'    =>  'Austria',
            'Azerbaijan'    =>  'Azerbaijan',
            'Bahamas'    =>  'Bahamas',
            'Bahrain'    =>  'Bahrain',
            'Bangladesh'    =>  'Bangladesh',
            'Barbados'    =>  'Barbados',
            'Belarus'    =>  'Belarus',
            'Belgium'    =>  'Belgium',
            'Belize'    =>  'Belize',
            'Benin'    =>  'Benin',
            'Bermuda'    =>  'Bermuda',
            'Bhutan'    =>  'Bhutan',
            'Bolivia'    =>  'Bolivia',
            'Bosnia And Herzegowina'    =>  'Bosnia And Herzegowina',
            'Botswana'    =>  'Botswana',
            'Bouvet Island'    =>  'Bouvet Island',
            'Brazil'    =>  'Brazil',
            'British Indian Ocean Territory'    =>  'British Indian Ocean Territory',
            'Brunei Darussalam'    =>  'Brunei Darussalam',
            'Bulgaria'    =>  'Bulgaria',
            'Burkina Faso'    =>  'Burkina Faso',
            'Burundi'    =>  'Burundi',
            'Cambodia'    =>  'Cambodia',
            'Cameroon'    =>  'Cameroon',
            'Canada'    =>  'Canada',
            'Cape Verde'    =>  'Cape Verde',
            'Cayman Islands'    =>  'Cayman Islands',
            'Central African Republic'    =>  'Central African Republic',
            'Chad'    =>  'Chad',
            'Chile'    =>  'Chile',
            'China'    =>  'China',
            'Christmas Island'    =>  'Christmas Island',
            'Cocos (Keeling) Islands'    =>  'Cocos (Keeling) Islands',
            'Colombia'    =>  'Colombia',
            'Comoros'    =>  'Comoros',
            'Congo'    =>  'Congo',
            'Congo'    =>  'Croatia',
            'Cuba'    =>  'Cuba',
            'Cyprus'    =>  'Cyprus',
            'Czech Republic'    =>  'Czech Republic',
            'Denmark'    =>  'Denmark',
            'Egypt'    =>  'Egypt',
            'Emirates'    =>  'Emirates',
            'Eritrea'    =>  'Eritrea',
            'Ethiopia'    =>  'Ethiopia',
            'Fiji'    =>  'Fiji',
            'Finland'    =>  'Finland',
            'France'    =>  'France',
            'Gambia'    =>  'Gambia',
            'Germany'    =>  'Germany',
            'Ghana'    =>  'Ghana',
            'Greece'    =>  'Greece',
            'Guinea'    =>  'Guinea',
            'Guyana'    =>  'Guyana',
            'Hong Kong'    =>  'Hong Kong',
            'Hungary'    =>  'Hungary',
            'Iceland'    =>  'Iceland',
            'India'    =>  'India',
            'Indonesia'    =>  'Indonesia',
            'Iran'    =>  'Iran',
            'Iraq'    =>  'Iraq',
            'Ireland'    =>  'Ireland',
            'Israel'    =>  'Israel',
            'Italy'    =>  'Italy',
            'Jamaica'    =>  'Jamaica',
            'Japan'    =>  'Japan',
            'Jordan'    =>  'Jordan',
            'Kazakhstan'    =>  'Kazakhstan',
            'Kenya'    =>  'Kenya',
            'Kosovo'    =>  'Kosovo',
            'Kuwait'    =>  'Kuwait',
            'Kyrgyzstan'    =>  'Kyrgyzstan',
            'Lebanon'    =>  'Lebanon',
            'Liberia'    =>  'Liberia',
            'Libya'    =>  'Libya',
            'Macedonia'    =>  'Macedonia',
            'Madagascar'    =>  'Madagascar',
            'Malawi'    =>  'Malawi',
            'Malaysia'    =>  'Malaysia',
            'Maldives'    =>  'Maldives',
            'Mali'    =>  'Mali',
            'Malta'    =>  'Malta',
            'Mauritania'    =>  'Mauritania',
            'Mauritius'    =>  'Mauritius',
            'Mexico'    =>  'Mexico',
            'Morocco'    =>  'Morocco',
            'Mozambique'    =>  'Mozambique',
            'Namibia'    =>  'Namibia',
            'Nauru'    =>  'Nauru',
            'Nepal'    =>  'Nepal',
            'Netherlands'    =>  'Netherlands',
            'NZ'    =>  'New Zealand',
            'Nigeria'    =>  'Nigeria',
            'Norway'    =>  'Norway',
            'Oman'    =>  'Oman',
            'Pakistan'    =>  'Pakistan',
            'Palestine'    =>  'Palestine',
            'Peru'    =>  'Peru',
            'Philippines'    =>  'Philippines',
            'Poland'    =>  'Poland',
            'Portugal'    =>  'Portugal',
            'Puerto Rico'    =>  'Puerto Rico',
            'Qatar'    =>  'Qatar',
            'Romania'    =>  'Romania',
            'Russian'    =>  'Russian',
            'Saudi Arabia'    =>  'Saudi Arabia',
            'Senegal'    =>  'Senegal',
            'Sierra Leone'    =>  'Sierra Leone',
            'Singapore'    =>  'Singapore',
            'Slovenia'    =>  'Slovenia',
            'Somalia'    =>  'Somalia',
            'South Africa'    =>  'South Africa',
            'South Korea'    =>  'South Korea',
            'Spain'    =>  'Spain',
            'Sri Lanka'    =>  'Sri Lanka',
            'Sudan'    =>  'Sudan',
            'Swaziland'    =>  'Swaziland',
            'Sweden'    =>  'Sweden',
            'Switzerland'    =>  'Switzerland',
            'Syria'    =>  'Syria',
            'Taiwan'    =>  'Taiwan',
            'Tajikistan'    =>  'Tajikistan',
            'Tanzania'    =>  'Tanzania',
            'Thailand'    =>  'Thailand',
            'Trinidad Tobago'    =>  'Trinidad Tobago',
            'Tunisia'    =>  'Tunisia',
            'Turkey'    =>  'Turkey',
            'TM'    =>  'Turkmenistan',
            'Uganda'    =>  'Uganda',
            'Ukraine'    =>  'Ukraine',
            'United Arab Emirates'    =>  'United Arab Emirates',
            'United Kingdom'    =>  'United Kingdom',
            'United States'    =>  'United States',
            'Uzbekistan'    =>  'Uzbekistan',
            'Venezuela'    =>  'Venezuela',
            'Viet Nam'    =>  'Viet Nam',
            'Yemen'    =>  'Yemen',
            'Zambia'    =>  'Zambia',
            'Zimbabwe'    =>  'Zimbabwe'
        );
        return $country_list;
    }

     public function getAllQualifications(){
        $qualifications = ["Pursuing Graduation"=>'Pursuing Graduation',"B.A"=>'B.A',"B.Arch"=>'B.Arch',"B.B.A"=>'B.B.A',"BCA"=>'BCA',"B.Com"=>'B.Com',"B.Ed"=>'B.Ed',"BDS"=>'BDS',"BHM"=>'BHM',"B.Pharma"=>'B.Phama',"B.Sc"=>'B.Sc',"B.Tech/B.E."=>'B.Tech/B.E.',"LLB"=>'LLB',"MBBS"=>'MBBS',"MBA"=>'MBA',"Diploma"=>'Diploma',"ITI"=>'ITI',"SSC"=>'SSC',"HSC"=>'HSC',"BVSC"=>'BVSC',"Other"=>'Other'];
        return $qualifications;
    }
}

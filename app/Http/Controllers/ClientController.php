<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;


class ClientController extends Controller
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

    public function getAllClients() : JsonResponse {
        return response()->json(Client::orderByDesc('client_id')->paginate(15));
    }

    public function getClient($id) : JsonResponse {
        return response()->json(Client::find($id));
    }

    public function addClient(Request $request) : JsonResponse {
        $reqPayload = $request->all();
        $file_name = $this->createFile($reqPayload["client_logo"]);
        $reqPayload["client_logo"] = $file_name;
        $client = Client::create($reqPayload);
        return response()->json($client, Response::HTTP_CREATED);
    }

    public function updateClient($id, Request $request) : JsonResponse {
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return response()->json($client, Response::HTTP_OK);
    }

    public function deleteClient($id) : JsonResponse {
        $client = Client::findOrFail($id);
        $client_name = $client->client_name;
        $client->delete();
        return response()->json("Client `".$client_name."` deleted successfully", Response::HTTP_OK);
    }

    public function createFile($dataUri) {
        $file_name = '';
        try{
            list($ext, $data) = explode(';', $dataUri);
            list(,$data) = explode(',', $data);
            $data = base64_decode($data);
            $file_name = mt_rand().time().'.png';
            $path = base_path().'/public/client_logos/';
            file_put_contents($path.$file_name, $data);
            return $file_name;
        } catch(\Exception $e){
            return($e);
        }
    }

    public function getAllClientsList() : JsonResponse {
        return response()->json(Client::orderByDesc('client_id')->get());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
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

    public function getAllEvents() : JsonResponse {
        return response()->json(Event::orderByDesc('news_id')->paginate(15));
    }

    public function getEvent($id) : JsonResponse {
        return response()->json(Event::find($id));
    }

    public function addEvent(Request $request) : JsonResponse {
        $reqPayload = $request->all();
        $file_name = $this->createFile($reqPayload["event_doc"]);
        $reqPayload["event_doc"] = $file_name;
        $event = Event::create($reqPayload);
        return response()->json($event, Response::HTTP_CREATED);
    }

    public function updateEvent($id, Request $request) : JsonResponse {
        $event = Event::findOrFail($id);
        $reqPayload = $request->all();
        if($reqPayload["event_doc"] && $reqPayload["event_doc"] != ""){
            $cert_file_name = $this->createFile($reqPayload["event_doc"]);
            $reqPayload["event_doc"] = $cert_file_name;
        }
        $event->update($reqPayload);
        return response()->json($event, Response::HTTP_OK);
    }

    public function deleteEvent($id) : JsonResponse {
        $event = Event::findOrFail($id);
        $event_title = $event->title;
        $event->delete();
        return response()->json("Event `".$event_title."` deleted successfully");
    }

    public function createFile($dataUri) {
        $file_name = '';
        try{
            list($ext, $data) = explode(';', $dataUri);
            list(,$data) = explode(',', $data);
            $data = base64_decode($data);
            $ext = explode('/', $ext);
            $file_name = mt_rand().time().'.'.$ext[1];
            $path = base_path().'/public/events_doc/';
            file_put_contents($path.$file_name, $data);
            return $file_name;
        } catch(\Exception $e){
            return($e);
        }
    }
}

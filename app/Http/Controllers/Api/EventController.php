<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;


class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events1 = Event::all();
            return response()->json([
                "success" => true,
                "message" => "Events List",
                "data" => $events1,
                "request" =>$request
            ]);

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Event::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Event::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Event::orderBy($columnName,$columnSortOrder)
               ->where('events.name', 'like', '%' .$searchValue . '%')
               ->orWhere('events.slug', 'like', '%' .$searchValue . '%')
              ->select('events.*')
              ->skip($start)
              ->take($rowperpage)
              ->get();

        $data_arr = array();

        foreach($records as $record){
           $id = $record->id;
           $name = $record->name;
           $slug = $record->slug;
           $startAt = $record->startAt;
           $endAt = $record->endAt;
           $created_at = $record->created_at;
           $updated_at = $record->updated_at;

           $data_arr[] = array(
               "id" => $id,
               "name" => $name,
               "slug" => $slug,
               "startAt" => $startAt,
               "endAt" => $endAt,
               "created_at" => $created_at,
               "updated_at" => $updated_at,
               "event_id" => $id,
           );
        }

        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response); 
    }

    /**
     * Show the form for creating a new event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EventRequest $request)
    {
        //
    }

    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'       => 'required|string',
            'slug'       => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
            ]);
        }

        $event = Event::create($input);

        return response()->json([
            "status_code" => 200,
            "success" => true,
            "message" => "Event created successfully.",
            "data" => $event,
        ]);
    }

    /**
     * Display the specified event.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cachedEvent = Redis::get('event_' . $id);


        if(isset($cachedEvent)) {
            $event = json_decode($cachedEvent, FALSE);

            return response()->json([
                'status_code' => 201,
                'message' => 'Fetched from redis',
                'data' => $event,
            ]);
        }else {
            $event = Event::find($id);
            Redis::set('event_' . $id, $event);

            return response()->json([
                'status_code' => 201,
                'message' => 'Fetched from database',
                'data' => $event,
            ]);
        }

        // //
        // $event = Event::find($id);
        // if (is_null($event)) {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Event not Found.",
        //     ]);
        // }

        return view('event.detail', [
            'events' => $event,
        ]);
    }

    /**
     * Display the specified event detail.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function showDetail($id)
    {
        //
        $event = Event::find($id);
        if (is_null($event)) {
            return response()->json([
                "success" => false,
                "message" => "Event not Found.",
            ]);
        }

    return view('event.detail', [
            'events' => $event,
        ]);
    }

    /**
     * Display editable the specified event.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function editDisplay($id)
    {
        //
        $event = Event::find($id);
        if (is_null($event)) {
            return response()->json([
                "success" => false,
                "message" => "Event not Found.",
            ]);
        }

    return view('event.edit', [
            'events' => $event,
        ]);
    }

    /**
     * Display all events that are active = current datetime is within startAt and endAt
     *
     * @return \Illuminate\Http\Response
     */
    public function activeEvent()
    {
        $nowDate = Carbon::now()->toDateTimeString();

        $active = DB::table('events')
           ->whereDate('startAt', '<=', $nowDate)
           ->whereDate('endAt', '>=', $nowDate)
           ->get();

            return response()->json([
                "success" => true,
                "message" => "Active Events List",
                "data" => $active
            ]);
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event, $id)
    {
        $input = $request->all();

        //identify either patch or put method request
        if($request->isMethod('put')){

            $validator = Validator::make($input, [
            'name'       => 'required|string',
            'slug'       => 'required|string',
        ]);

            if($validator->fails()){
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors(),
                ]);
            }

            

        }

        //if id exist , update the event, if not create new event 
        if (Event::where('id', $id)->exists()) {
            $event = Event::find($id);
        } else {
            $event->name = is_null($input['name']) ? $event->name : $input['name'];
            $event->slug = is_null($input['slug']) ? $event->slug : $input['slug'];
            $event->startAt = is_null($input['startAt']) ? $event->startAt : $input['startAt'];
            $event->endAt = is_null($input['endAt']) ? $event->endAt : $input['endAt'];
            $event->updated_at = Carbon::now()->toDateTimeString();
            // $event->save();

            $event = Event::create($input);

            return response()->json([
                'status_code' => 200,
                "success" => true,
                "message" => "Exist Event Not Found, Create New Event Successfully",
                "get_by" => "database",
                "data" => $event,
            ]);
        }

        $update = Event::findOrFail($id)->update($input);

        if($update) {

            // Delete event_$id from Redis
            Redis::del('event_' . $id);

            $event = Event::find($id);
            // Set a new key with the event id
            Redis::set('event_' . $id, $event);

            return response()->json([
                'status_code' => 200,
                'message' => 'Event updated',
                'get_by' => 'redis',
                'data' => $event,
            ]);
        } 
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

    /**
     * Delete using sofDelete the specified event from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function delete(Event $event, $id)
    {
        $event = Event::find( $id );
        $event->delete();
        return response()->json([
            "success" => true,
            "message" => "Event deleted successfully.",
        ]);
    }


    
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
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
    public function index()
    {
        $events = Event::all();
            return response()->json([
                "success" => true,
                "message" => "Events List",
                "data" => $events
            ]);
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
        //
        $event = Event::find($id);
        if (is_null($event)) {
            return response()->json([
                "success" => false,
                "message" => "Event not Found.",
            ]);
        }

        return response()->json([
                "success" => true,
                "message" => "Event retrieved successfully.",
                "data" => $event
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

        //identify either patch or put method request
        if($request->isMethod('put')){
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
        } else {
            $input = $request->all();

        }

        //if id exist , update the event, if not create new event 
        if (Event::where('id', $id)->exists()) {
            $event = Event::find($id);
        }
        $event->name = is_null($input['name']) ? $event->name : $input['name'];
        $event->slug = is_null($input['slug']) ? $event->slug : $input['slug'];
        $event->startAt = is_null($input['startAt']) ? $event->startAt : $input['startAt'];
        $event->endAt = is_null($input['endAt']) ? $event->endAt : $input['endAt'];
        $event->updated_at = Carbon::now()->toDateTimeString();
        $event->save();

        return response()->json([
            "success" => true,
            "message" => Event::where('id', $id)->exists() ? "Event updated successfully." : "Exist Event Not Found, Create New Event Successfully",
            "data" => $event
        ]);
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

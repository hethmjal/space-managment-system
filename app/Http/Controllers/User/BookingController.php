<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Space;
use App\Models\User;
use App\Notifications\NewBookNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{

    public function create()
    {
        $spaces = Space::get();
        return view('user.create',compact('spaces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'space_id' => 'required',
            'program_name' => 'required',
            'from' => 'required',
            'to' => 'required|after:from',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after_or_equal:start_date',
            'email' => 'required',
        ]);

       $space = Space::findOrFail($request->input('space_id'));
        
       $available = $space->checkAvailability($request);
        if (!$available) {
            return redirect()->back()->with('error','Space not available for selected dates');
        }

       $book = Booking::create([
            'name' => $request->input('name'),
            'program_name' => $request->input('program_name'),
            'user_id' => $request->input('user_id'),
            'space_id' => $request->input('space_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'status' => 'pending',
            'email' =>  $request->input('email'),
            'days' => $request->input('days'),
        ]);

        $users = User::where('type','admin')->get();
        Notification::send($users,new NewBookNotification);
       
        return redirect()->back()->with('success', 'Your reservation request is now under review, We will contact you in '.$book->email);
    
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Actions\BookingsAction;
use App\Events\NewBookingCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
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

    public function store(BookingRequest $request)
    {
       $space = Space::findOrFail($request->input('space_id'));
        
       $available = $space->checkAvailability($request);
        if (!$available) {
            return redirect()->back()->with('error','Space not available for selected dates');
        }

       $action = new BookingsAction();
       $book = $action->createAction($request,'pending');
       event(new NewBookingCreated($book));
       
       return redirect()->back()->with('success', 'Your reservation request is now under review, We will contact you in '.$book->email);
    
    }
}

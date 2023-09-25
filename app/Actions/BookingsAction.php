<?php
namespace App\Actions;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsAction {

    public function createAction(BookingRequest $request,$status): Booking
    {
        $book = Booking::create([
            'name' => $request->input('name'),
            'program_name' => $request->input('program_name'),
            'user_id' => $request->input('user_id'),
            'space_id' => $request->input('space_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'email' =>  $request->input('email'),
            'status' => $status,
            'days' => $request->input('days'),
        ]);

        return $book;
    } 


    public function updateAction(Booking $book,BookingRequest $request): Booking
    {
        $book->update([
            'name' => $request->input('name'),
            'program_name' => $request->input('program_name'),
            'user_id' => $request->input('user_id'),
            'space_id' => $request->input('space_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'email' => $request->input('email'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'days' => $request->input('days'),
        ]);

        return $book;
    } 
}
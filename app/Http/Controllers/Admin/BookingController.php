<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Space;
use App\Notifications\ChangeBookStatusnotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function index()
    {
        $spaces = Space::get();
        $bookings = Booking::latest()->get();
        return view('admin.booking.index',compact('bookings','spaces'));
    }

    public function create()
    {
        $spaces = Space::get();
        return view('admin.booking.create',compact('spaces'));
    }

    public function getDays($id)
    {
        $space = Space::findOrFail($id);
        $days = $space->availability;
        return $days;
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
            'days' => 'required',
        ]);
       // dd($request->all());

       $space = Space::findOrFail($request->input('space_id'));
        
       // dd($space->bookings);
       $available = $space->checkAvailability($request);
        if (!$available) {
            return redirect()->route('bookings.index')->with('error','Space not available for selected dates');
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
            'email' => $request->input('email'),
            'status' => 'accepted',
            'days' => $request->input('days'),
        ]);

       
        return redirect()->route('bookings.index')->with('success', 'Reservation successful');
    
    }

    public function edit($id)
    {
        $book = Booking::findOrFail($id);
        $spaces = Space::get();
        return view('admin.booking.edit',compact('book','spaces'));
    }

    public function update(Request $request,$id)
    {
        $book = Booking::findOrFail($id);
        $space = Space::findOrFail($request->input('space_id'));
        $request->validate([
            'name' => 'required',
            'space_id' => 'required',
            'program_name' => 'required',
            'from' => 'required',
            'to' => 'required|after:from',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after_or_equal:start_date',
            'email' => 'required',
            'days' => 'required',
        ]);


        $available = $space->checkAvailability($request,$id);
        if (!$available) {
            return redirect()->route('bookings.index')->with('error','Space not available for selected dates');
        }
        
        $book->update([
            'name' => $request->input('name'),
            'program_name' => $request->input('program_name'),
            'user_id' => $request->input('user_id'),
            'space_id' => $request->input('space_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'status' => 'accepted',
            'days' => $request->input('days'),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Book updated successful');
    }

   


    public function destroy($id)
    {
       Booking::destroy($id);
       return redirect()->route('bookings.index')->with('success', 'Deleted successful');
    }

    public function status(Request $request)
    {
       
        $book = Booking::findOrFail($request->id);  
        $book->status = $request->status;
        $book->save();
     
        Notification::route('mail', $book->email)
                ->notify(new ChangeBookStatusnotification($book));
        return $book;
    }

    public function search(Request $request)
    {
        $spaces = Space::get();
        $bookings = Booking::
        when(request('status') , function ($q) use($request) {
            return $q->where('status',$request->status);
        })
        ->when(request('space') , function ($q) use($request) {
            return $q->where('space_id',$request->space);
        })->
        where(
            function($q) use($request){
                return $q
                ->when(request('value') , function ($q) use($request) {
                    return $q->where('email','LIKE',"%{$request->value}%")
                    ->orWhere('name','LIKE',"%{$request->value}%")
                    ->orWhere('program_name','LIKE',"%{$request->value}%")
                    ->orWhere('start_date','LIKE',"%{$request->value}%")
                    ->orWhere('end_date','LIKE',"%{$request->value}%")
             
                    ;
                });
            }
        )
        
       ->with('space')->latest()->get();

  //    return $bookings;
        $html = '';

        foreach ($bookings as $index => $book) {
            $html = $html .' <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . $book->name . '</td>
                        <td>' . $book->email . '</td>
                        <td>' . $book->program_name . '</td>
                        <td>' . $book->space->name . '</td>
                        <td>';

            foreach ($book->days as $day) {
                $html = $html . $day . ' - ';
            }

            $html = $html . '</td>
                        <td>' . $book->start_date . '</td>
                        <td>' . $book->end_date . '</td>
                        <td>' . $book->from . ' - ' . $book->to . '</td>
                        <td>
                            <form action="' . route('change-status') . '" id="status" method="post">
                                ' . csrf_field() . '
                                <input type="hidden" name="id" value="' . $book->id . '">
                                <input type="hidden" name="stat' . $index . '" id="stat' . $index . '" value="">
                                <select name="status" id="thestatus' . $index . '" onchange="send(\'status\',' . $index . ',' . $book->id . ')">
                                    <option ' . ($book->status == "accepted" ? "selected" : "") . ' value="accepted">accepted</option>
                                    <option ' . ($book->status == "pending" ? "selected" : "") . ' value="pending">pending</option>
                                    <option ' . ($book->status == "rejected" ? "selected" : "") . ' value="rejected">rejected</option>
                                    <option ' . ($book->status == "expired" ? "selected" : "") . ' value="expired">expired</option>
                                </select>
                            </form>
                         </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="">
                                    <a  href="' . route('bookings.edit', $book->id) . '" class="btn btn-sm btn-success success-shadow">
                                        <i class="fa-solid fa-pen px-0"></i>
                                    </a>
                                </div>
                                <div class="ml-1">   
                                    <form action="' . route('bookings.destroy', $book->id) . '" method="post">
                                        ' . csrf_field() . '
                                        ' . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-sm btn-danger danger-shadow">
                                            <i class="fa-solid fa-trash-can px-0"></i>
                                        </button>
                                    </form>  
                                </div>
                            </div>
                        </td>
                    </tr>';

       
    }

    return response()->json([
        'html' => $html,
        'spaces'=>$spaces,
        'bookings' => $bookings
    ]);
    }
 
}

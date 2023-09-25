<?php

namespace App\Http\Controllers\Admin;

use App\Actions\BookingsAction;
use App\Events\BookingStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
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
        $bookings = Booking::latest()->lazy();
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

    public function store(BookingRequest $request)
    {
       $space = Space::findOrFail($request->input('space_id'));
        $available = $space->checkAvailability($request);
        if (!$available) {
            return redirect()->route('bookings.index')
            ->with('error','Space not available for selected dates');
        }
        $action = new BookingsAction();
        $book = $action->createAction($request,'accepted');
       
        return redirect()->route('bookings.index')->with('success', 'Reservation successful');
    }

    public function edit($id)
    {
        $book = Booking::findOrFail($id);
        $spaces = Space::get();
        return view('admin.booking.edit',compact('book','spaces'));
    }

    public function update(BookingRequest $request,$id)
    {
        $book = Booking::findOrFail($id);
        $space = Space::findOrFail($request->input('space_id'));
       
        $available = $space->checkAvailability($request,$id);
        if (!$available) {
            return redirect()->route('bookings.index')->with('error','Space not available for selected dates');
        }
        
        $action = new BookingsAction();
        $book = $action->updateAction($book,$request);

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

        event(new BookingStatusChanged($book));
        return $book;
    }

    public function search(Request $request)
    {
        
        $bookings = Booking::filter($request)->with('space')->latest()->get();
        $spaces = Space::get();
        $html = '';
        foreach ($bookings as $index => $book) {
         $html = $this->getHtml($book,$html,$index);
        }
        return response()->json([
            'html' => $html,
            'spaces'=>$spaces,
            'bookings' => $bookings
        ]);
    }
 

    private function getHtml($book,$html,$index){
     
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
    
            return $html;
    }
}

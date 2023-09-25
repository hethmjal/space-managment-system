<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Space extends Model
{
    protected $fillable = ['name', 'availability','user_id','capacity','location','type'];


    protected $casts = ['availability' => 'array'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'space_id','id');
    }
    
    public function checkAvailability($request,$id = null)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $from = $request->from;
        $to = $request->to;
        $days = $request->days;
        
        $bookings = $this->bookings()->where(function($query) use($start_date, $end_date){
            $query->whereBetween('start_date', [$start_date, $end_date])
           ->orWhereBetween('end_date', [$start_date, $end_date])
           ->orWhere(function($query) use ($start_date, $end_date) {
                $query->where('start_date', '<=', $start_date)
                        ->where('end_date', '>=', $end_date);
            });
        })->where('id','!=',$id)->get();
     
        foreach ($bookings as $booking) {
            if(($booking->from > $from && $booking->from > $to ) || ($booking->to < $from && $booking->from < $to)){
               continue;
            }else{
              
                foreach ($days as  $index => $day) {
                    if (!in_array($day,$booking->days)) {
                        if($index+1 == count($days)){
                            continue 2;
                        }
                        continue;
                       
                    }
                }

               
                return false;
            }
           
        }

        return true;
    }

}


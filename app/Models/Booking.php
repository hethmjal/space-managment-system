<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','days','user_id','program_name', 'space_id', 'start_date', 'end_date','status','from','to'];
    protected $casts = ['days' => 'array'];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function to(): Attribute 
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('H:m'),
            set: fn (string $value) => Carbon::parse($value)->format('H:m'),
        );
    }

    protected function from(): Attribute 
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('H:m'),
            set: fn (string $value) => Carbon::parse($value)->format('H:m'),
        );
    }

    
    public function scopeFilter($query,$request)
    {
        return $query->when(request('status') , function ($q) use($request) {
            return $q->where('status',$request->status);
        })
        ->when(request('space') , function ($q) use($request) {
            return $q->where('space_id',$request->space);
        })->
        where(
            function($q) use($request){
                return $q->when(request('value') , function ($q) use($request) {
                    return $q->where('email','LIKE',"%{$request->value}%")
                    ->orWhere('name','LIKE',"%{$request->value}%")
                    ->orWhere('program_name','LIKE',"%{$request->value}%")
                    ->orWhere('start_date','LIKE',"%{$request->value}%")
                    ->orWhere('end_date','LIKE',"%{$request->value}%")
             
                    ;
                });
            }
        );
    }



}

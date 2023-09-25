<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            
                'name' => 'required',
                'space_id' => 'required',
                'program_name' => 'required',
                'from' => 'required',
                'to' => 'required|after:from',
                'start_date' => 'required|date|after_or_equal:now',
                'end_date' => 'required|date|after_or_equal:start_date',
                'email' => 'required',
                'days' => 'required',
            
        ];
    }
}

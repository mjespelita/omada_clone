<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'sites_id' => 'required',
            'date_reported' => 'required',
            'name' => 'required',
            'ticket_type' => 'required',
            'address' => 'required',
            'nearest_landmark' => 'required',
            'issue' => 'required',
            'troubleshooting' => 'required',
        ];
    }
}

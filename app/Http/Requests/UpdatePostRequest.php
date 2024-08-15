<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if you want to restrict access
    }

    public function rules()
    {
        return [
            'Name' => 'sometimes|required|string|max:255',
            'Description' => 'sometimes|required|string',
            'Image' => 'sometimes|image|mimes:gif,png,jpeg,jpg|max:2048',
            'Status' => 'sometimes|required'
        ];
    }
}

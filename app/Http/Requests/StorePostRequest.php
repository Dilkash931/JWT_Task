<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if you want to restrict access
    }

    public function rules()
    {
        return [
            'Name' => 'required|string|max:255',
            'Description' => 'required|string',
            'Image' => 'required|image|mimes:gif,png,jpeg,jpg|max:2048',
            'Status' => 'required' // Assuming status has fixed values
        ];
    }
}

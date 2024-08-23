<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->storeRules();
        } else {
            return $this->updateRules();
        }
    }

    // Validation rules for storing a post.
    
    protected function storeRules()
    {
        return [
            'Name' => 'required|string|max:255',
            'Description' => 'required|string',
            'Image' => 'required|image|mimes:gif,png,jpeg,jpg|max:2048',
            'Status' => 'required' 
        ];
    }

    //Validation rules for updating a post.
   
    protected function updateRules()
    {
        return [
            'Name' => 'sometimes|required|string|max:255',
            'Description' => 'sometimes|required|string',
            'Image' => 'sometimes|image|mimes:gif,png,jpeg,jpg|max:2048',
            'Status' => 'sometimes|required'
        ];
    }
}

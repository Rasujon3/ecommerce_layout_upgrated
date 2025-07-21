<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'area_name' => 'required|string|max:50|unique:ariadhakas,area_name,' . $this->ariadhaka->id,
            'area_type' => 'required|in:Inside Dhaka,Outside Dhaka',
            'status' => 'required|in:Active,Inactive',
        ];
    }
}

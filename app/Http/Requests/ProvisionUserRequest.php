<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvisionUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
           'first_name' => 'required',
           'last_name' => 'required',
           'org_email' => 'required|email',
           'ext_email' => 'required|email|different:org_email'
        ];
    }

    public function messages() {
       return [
          'first_name.required' => 'Please enter a first name',
          'last_name.required' => 'Please enter a last name',
          'org_email.required' => 'Please enter the new organizational email',
          'ext_email.required' => 'Please enter an existing external email address for the new user',
          'ext_email.different' => 'The external email cannot be the same as the organizational email',
       ];
    }
}

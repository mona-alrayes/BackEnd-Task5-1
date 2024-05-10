<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Traits\HasRoles;



class AddUserRequest extends FormRequest
{
    use HasRoles;
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
            'name' => ['required','max:255','string'],
            'email' => ['required','max:255','string','email','unique:users,email'],
            'password' => ['required','max:255','string','min:8','confirmed'],
        ];
    }
}

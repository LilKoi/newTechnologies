<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppCategoryPositionsRequest extends FormRequest
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
            "applicationId" => ["required", 'integer'],
            "countryId" => ["required", 'integer'],
            "dateFrom" => ["required", "date"],
            "dateTo" => ["required", "date"]
        ];
    }
}

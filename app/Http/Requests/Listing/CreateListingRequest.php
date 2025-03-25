<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest extends FormRequest
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
      'name' => 'required|string',
      'category_id' => 'required|exists:categories,id',
      'description' => 'nullable',
      'address' => 'required',
      'rating' => 'required',
      'info' => 'required',
      'image_url' => 'nullable',
    ];
  }
}

<?php

namespace App\Http\Requests;

use App\Models\Stock;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class StoreStockRequest extends FormRequest
{
    protected $methode;

    public function __construct()
    {
        $this->methode = request()->get('methode');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', Stock::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            "article_id" => ['required', "exists:cc_articles,id"],
            "zones.*"  => ['nullable', 'numeric'],
        ];
        if ($this->methode == "savewhat") {
            return array_intersect_key($rules, request()->all());
        }
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            "article_id" => "Article",
            "zones.*" => "Zone",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => 'Validation failed.',
            'error_messages' => $validator->errors()->messages(),
        ], 200));
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class StoreArticleRequest extends FormRequest
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
        return Gate::allows('create', Article::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            "prospect_id" => ['required', "exists:com_prospects,id"],
            "ref" => ['required', 'max:50'],
            "designation" => ['nullable', 'max:150'],
            "puht" => ['nullable', 'numeric', 'regex:/^((?!0)\d{1,10}|0|\.\d{1,2})($|\.$|\.\d{1,2}$)/'],
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
            "prospect_id" => "Client",
            "ref" => "Référence",
            "designation" => "Désignation",
            "puht" => "PU",
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

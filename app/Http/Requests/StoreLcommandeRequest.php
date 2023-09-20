<?php

namespace App\Http\Requests;

use App\Models\Commande;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class StoreLcommandeRequest extends FormRequest
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
        return Gate::allows('create', Commande::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "commande_id" => ['required', "exists:cc_commandes,id"],
            "articles.*.qty"  => ['required', 'numeric'],
            "articles.*.id"  => ['required', 'exists:cc_articles,id'],
        ];
        if ($this->has('lcommande')) {
            $rules = [
                "commande_id" => ['required', "exists:cc_commandes,id"],
                "qty"  => ['required', 'numeric', 'min:1'],
                "pu" => ['required', 'numeric', 'regex:/^((?!0)\d{1,10}|0|\.\d{1,2})($|\.$|\.\d{1,2}$)/'],
                "article_id"  => ['required', 'exists:cc_articles,id'],
            ];
        }
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
            "commande_id" => "Commande",
            "articles.*.qty" => "Quantité",
            "qty" => "Quantité",
            "pu" => "Prix unitaire",
            "articles.*.id" => "Article",
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

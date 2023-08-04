<?php

namespace App\Http\Requests;

use App\Models\Commande;
use App\Rules\DateFormatFR;
use App\Rules\UpdateCommandeStatutRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreCommandeRequest extends FormRequest
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
        $_in_prospect = match (Gate::allows('is_client', [App\Models\User::class])) {
            true => "in:" . Auth::user()->client,
            false => "",
        };

        $rules = [
            "client_id" => ['required', "exists:com_prospects,id", $_in_prospect],
            "statut_id" => ['nullable', 'exists:cc_commande_statuts,id', new UpdateCommandeStatutRule($this)],
            "date_livraison_souhaitee" => ['nullable', new DateFormatFR('d/m/Y')],
            "date_livraison_confirmee" => ['nullable', new DateFormatFR('d/m/Y')],
            "articles.*.qty"  => ['nullable', 'numeric'],
            "articles.*.id"  => ['nullable', 'exists:cc_articles,id'],
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
            "client_id" => "Client",
            "statut_id" => "Statut",
            "date_livraison_souhaitee" => "Date livraison souhaitée",
            "date_livraison_confirmee" => "Date livraison confirmée",
            "articles.*.qty" => "Quantité",
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

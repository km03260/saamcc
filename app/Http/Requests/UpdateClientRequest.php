<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class UpdateClientRequest extends FormRequest
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
        return Gate::allows('update', [Client::class, $this->client]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            "raison_sociale" => ['required', 'max:70', "unique:com_prospects,raison_sociale," . request()->client?->id],
            "type" => ['nullable', 'in:prospect,client,prescripteur'],
            "code_magisoft" => ['nullable', 'max:50'],
            "adresse1" => ['nullable', 'string', 'max:150'],
            "adresse2" => ['nullable', 'string', 'max:150'],
            "cp" => ['required', 'string', 'max:10'],
            "ville" => ['required', 'string', 'max:50'],
            "pays" => ['nullable', 'string', 'max:50'],
            "account" => ['nullable', 'string', 'max:50', 'exists:sso_user,id'],
            "activite" => ['nullable', 'string', 'max:200'],
            "siteweb" => ['nullable', 'string', 'max:100'],
            "business" => ['nullable', 'string'],
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
            "adresse1" => "adresse",
            "adresse2" => "adresse",
            "code_magisoft" => "Code magisoft",
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

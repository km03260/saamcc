<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UpdateCommandeStatutRule implements ValidationRule
{
    public function __construct(public Request $params)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->params->commande && $this->params->has('statut_id') && $this->params->statut_id == 2) {
            if (!Gate::allows('can_valider', [App\Models\Commande::class, $this->params->commande])) {
                $fail("Avant de valider la commande, vous devez saisir la date de livraison souhaitée.");
            }
        }
    }
}

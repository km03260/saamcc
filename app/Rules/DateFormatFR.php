<?php

namespace App\Rules;

use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

class DateFormatFR implements ValidationRule
{

    public function __construct(public string $format)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute,  mixed $value, Closure $fail): void
    {
        $date = DateTime::createFromFormat($this->format, $value);
        if (!$date) {
            $fail("Le champ :attribute doit respecter le format $this->format.");
        }
    }
}

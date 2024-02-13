<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRequirementsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        return preg_match('/[A-Z]/', $value) && preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $value);
    }

    public function message()
    {
        return 'A senha deve conter pelo menos uma letra maiúscula e um caractere especial.';
    }
}

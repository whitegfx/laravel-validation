<?php

namespace Whitegfx\LaravelValidation\Rules;

use Czechphp\CzechBankAccount\Validator\BankAccountNumberValidator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Exception;

class BankNumber
{
    // https://github.com/ivolo/disposable-email-domains#api
    public function validateBankNumber($attribute, $value)
    {
        $validator = new BankAccountNumberValidator();
        $violation = $validator->validate($value, [
            'type' => BankAccountNumberValidator::OPTION_TYPE_VARIABLE,
        ]);

        if ($violation === BankAccountNumberValidator::ERROR_NONE) {
            return true;
        }
        return false;
    }
}

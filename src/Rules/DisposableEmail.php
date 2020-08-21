<?php

namespace Whitegfx\LaravelValidation\Rules;

use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Exception;

class DisposableEmail extends Validator
{
    public function validateDisposableEmail($attribute, $value)
    {
        $url = 'https://open.kickbox.com/v1/disposable/' .
            Str::after($value, '@');
        try {
            return !json_decode(file_get_contents($url), true)['disposable'];
        } catch (Exception $ex) {
            return ($this->parameters[0] ?? false) ? false : true;
        }
    }
}

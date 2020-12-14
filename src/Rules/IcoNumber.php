<?php

namespace Whitegfx\LaravelValidation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Exception;

class IcoNumber
{
    // https://github.com/ivolo/disposable-email-domains#api
    public function validateIcoNumber($attribute, $value)
    {

        // be liberal in what you receive
        $ic = preg_replace('#\s+#', '', $value);

        // má požadovaný tvar?
        if (!preg_match('#^\d{8}$#', $ic)) {
            return false;
        }

        // kontrolní součet
        $a = 0;
        for ($i = 0; $i < 7; $i++) {
            $a += $ic[$i] * (8 - $i);
        }

        $a = $a % 11;
        if ($a === 0) {
            $c = 1;
        } elseif ($a === 1) {
            $c = 0;
        } else {
            $c = 11 - $a;
        }

        return (int) $ic[7] === $c;
    }
}

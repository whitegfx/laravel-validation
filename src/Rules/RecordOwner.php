<?php

namespace Whitegfx\LaravelValidation\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Str;

// credits https://itnext.io/laravel-validation-rule-record-owner-3f2adf86902d
class RecordOwner
{

    public function validateRecordOwner($attribute, $value, $parameters): bool
    {
        if (Auth::user()->isAdmin()) {
            return true;
        }

        if (!isset($parameters) || count($parameters) < 3) {
            $route = request()->route();
            $table = $route->parameterNames[0];
            $field = 'id';
            $rowId = $route->parameters[$table];
            $table = Str::snake($table);
        } else {

            $table = $parameters[0];
            $field = $parameters[1];
            $rowId = $parameters[2];
        }

        // dd([$table, $field, $rowId], [Str::plural($table)], request()->route(), Auth::user()->isAdmin(), $attribute, $value, $parameters);

        $authId = Auth::id();
        $exists = DB::table(Str::plural($table))
            ->where($field, $rowId)
            ->where('user_id', $authId)
            ->exists();
        //dd([$table, $field, $rowId], request()->route(), Auth::user()->isAdmin(), $exists, $attribute, $value, $parameters);

        return $exists;
    }
}

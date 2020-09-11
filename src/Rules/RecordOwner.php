<?php

namespace Whitegfx\LaravelValidation\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Str;

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
        } else {
            $table = $parameters[0];
            $field = $parameters[1];
            $rowId = $parameters[2];
        }

        $authId = Auth::id();
        $exists = DB::table(Str::plural($table))
            ->where($field, $rowId)
            ->where('user_id', $authId)
            ->exists();
        //        dd([$table, $field, $rowId], request()->route(), Auth::user()->isAdmin(), $exists, $attribute, $value, $parameters);

        return $exists;
    }
}

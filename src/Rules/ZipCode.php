<?php

namespace Whitegfx\LaravelValidation\Rules;

use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Storage;
use App;
use Illuminate\Filesystem\Filesystem;

class ZipCode
{
    // https://github.com/ivolo/disposable-email-domains#api
    public function validateZipCode($attribute, $value)
    {
        try {
            $zipCocdes = $this->getCsvColumn();
            if (count($zipCocdes) == 0) {
                return false;
            }
            $zipCodeFound = in_array($value, $zipCocdes);
            return $zipCodeFound;
        } catch (Exception $ex) {
            dd($ex);
            return ($this->parameters[0] ?? false) ? false : true;
        }
    }
    // https://www.posta.sk/sluzby/postove-smerovacie-cisla
    // https://www.ceskaposta.cz/documents/10180/3738087/db_psc_a.zip/d28208a4-279a-10e3-205a-e44ccc6214b2
    protected function getCsvColumn($columnIndex = 0, $isStringColumn = false, $columnName = "")
    {

        $format = env('ZIP_CODES_FORMAT', "zip_codes_%s.csv");
        $locale = App::getLocale();

        $codes = array();
        $fileName = sprintf($format, $locale);

        // resources vendor file
        $csvPath = resource_path('vendor/laravel-validation/json/' . $fileName);
        $filesystem = new Filesystem;
        $isExists = $filesystem->exists($csvPath);

        // package file
        if (!$isExists) {
            $csvPath = __DIR__ . '/../../resources/json/' . $fileName;
            $isExists = $filesystem->exists($csvPath);
        }

        $linesArray = @file($csvPath, FILE_SKIP_EMPTY_LINES);

        if ($linesArray === false) {
            return array();
        }

        $csv = array_map(function ($value) {
            return str_getcsv($value, ';');
        }, $linesArray);

        $header = array_shift($csv);
        // Seperate the header from data

        $col = $columnName !== "" ? array_search($columnName, $header) : $columnIndex;

        foreach ($csv as $row) {
            $codes[] = $isStringColumn ? $row[$col] : (int)$row[$col];
        }

        return $codes;
    }
}

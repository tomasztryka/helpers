<?php

use Illuminate\Support\Str;

if (!function_exists('multiExplode')) {
    function multiExplode($text, $separators = ':|-|\*|=|_| ')
    {
        return preg_split('/(' . $separators . ')/', $text);
    }
}

if (!function_exists('prepareAcronym')) {
    function prepareAcronym(array $names)
    {
        $names = array_map(function ($string) {
            return substr(Str::ucfirst($string), 0, 1);
        }, $names);

        return implode('', $names);
    }
}

if (!function_exists('padLeft')) {
    function padLeft($value, $length, $pad = ' ')
    {
        return str_pad($value, $length, $pad, STR_PAD_LEFT);
    }
}

if (!function_exists('toBool')) {
    function toBool($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('removeSortByFromRequestQuery')) {
    function removeSortByFromRequestQuery()
    {
        request()->query->set('sort_by', null);
    }
}

if (!function_exists('isJoined')) {
    function isJoined($query, $table)
    {
        return collect($query->getQuery()->joins)->pluck('table')->contains($table);
    }
}

if (!function_exists('commaExplode')) {
    function commaExplode(string $string): array
    {
        if (empty($string)) {
            return [];
        }

        return explode(',', $string);
    }
}

if (!function_exists('commaImplode')) {
    function commaImplode(array $array): string
    {
        if (empty($array)) {
            return '';
        }

        return implode(',', $array);
    }
}
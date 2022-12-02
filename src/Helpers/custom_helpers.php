<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

if (!function_exists('arrayIsAccessibleAndNotEmpty')) {
    function arrayIsAccessibleAndNotEmpty(?array $array): bool
    {
        return Arr::accessible($array) && !empty($array);
    }
}

if (!function_exists('sameCollections')) {
    function sameCollections($first, $second): bool
    {
        $first = collect($first);
        $second = collect($second);

        if ($first->count() !== $second->count()) {
            return false;
        }

        return !$first->diff($second)->isNotEmpty() || !$second->diff($first)->isNotEmpty();
    }
}

if (!function_exists('getLikeStyle')) {
    function getLikeStyle()
    {
        return DB::getDriverName() === 'pgsql' ? 'ilike' : 'like';
    }
}

if (!function_exists('ucfirstCamelCase')) {
    function ucfirstCamelCase(string $string): \Illuminate\Support\Stringable
    {
        return Str::of($string)->camel()->ucfirst();
    }
}

if (!function_exists('toDecimalWithTwoPlaces')) {
    function toDecimalWithTwoPlaces(mixed $value): string
    {
        return number_format($value, 2, '.', '');
    }
}

if (!function_exists('getTableColumnsListFromModelClass')) {
    function getTableColumnsListFromModelClass(string $model): array
    {
        $ttl = Carbon::SECONDS_PER_MINUTE;
        $tableName = Str::of(class_basename($model))->plural()->snake();

        return Cache::remember($tableName . '_list_of_columns', $ttl, fn() => Schema::getColumnListing($tableName));
    }
}

if (!function_exists('convertArrayKeysToSnakeCaseWithDigits')) {
    function convertArrayKeysToSnakeCaseWithDigits($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $array = [];

        foreach ($data as $key => $value) {
            $arrayKey = preg_replace_callback(
                '|\d+|',
                function ($matches) {

                    return '_' . $matches[0];
                },
                (string)Str::of($key)->snake()
            );

            $array[$arrayKey] = is_array($value) ? convertArrayKeysToSnakeCaseWithDigits($value) : $value;
        }

        return $array;
    }
}

if (!function_exists('nestedKeyExist')) {
    function nestedKeyExist(array $array, string $key): bool
    {
        // is in base array?
        if (array_key_exists($key, $array)) {
            return true;
        }

        // check arrays contained in this array
        foreach ($array as $element) {
            if (is_array($element)) {
                if (nestedKeyExist($element, $key)) {
                    return true;
                }
            }

        }

        return false;
    }
}
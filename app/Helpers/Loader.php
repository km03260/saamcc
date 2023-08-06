<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Loader
{

    /**
     * Redirect to profile ssoserver
     *
     * @return string
     */
    public static function SSOSERVER()
    {
        return Str::replaceLast('server', 'users/Compte/profile', env('SSO_SERVER_URL'));
    }

    /**
     * Quantité de colorant
     *
     * @return number
     */
    public static function COE_COLORANT()
    {
        // return Params::where('bloc', 'matiere-composant')->where('nom', 'LIKE', '%colorant%')->value('valeur') ?? 0;
    }

    /**
     * Get file content
     */
    public static function csvToValue($filename = '', $delimiter = ',', $from_encoding = 'UTF-8', $to_encoding = 'UTF-8', $appends = null)
    {

        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = "";

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, null, $delimiter)) !== false) {
                if (!$header) {
                    $header = \array_map(function ($ht) use ($from_encoding, $to_encoding) {
                        return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', str_replace('"', '', Str::lower(mb_convert_encoding($ht, $to_encoding, $from_encoding))));
                    }, $row);
                    array_push($header, null);
                } else {
                    \array_push($row, $appends);
                    $values = $row;
                    $row_values = "";
                    foreach (mb_convert_encoding($values, $to_encoding, $from_encoding) as $key => $value) {
                        $row_values .= ',' . (($value != null && $value != '') ? str_replace(["\r", '?'], '', $value) : '');
                    }
                    if (trim($row_values, ',') != "") {
                        $data .= "(" . trim($row_values, ',') . '),';
                    }
                }
            }
            fclose($handle);
        }
        return rtrim($data, ',');
    }

    /**
     * Sort array by another array values
     *
     * @param array $array
     * @param array $orderArray
     * @param  $strict
     * @return array
     */
    private function sortArray(array $array, array $orderArray, $strict = null): array
    {
        if (!empty($array) && !empty($orderArray)) {
            $ordered = [];
            foreach ($orderArray as $key => $item) {
                if (key_exists($item, $array)) {
                    $ordered[$item] = $array[$item];
                } else {
                    return $array;
                    break;
                }
            }

            return $ordered;
        } else {
            return $array;
        }
    }

    /**
     * Parse weeks
     *
     * @param String $start Weak/Year
     * @param String $end Weak/Year
     * @return array
     */
    public static function parseWeeks($exists_week, $start, $end): array
    {
        $weeks = [];
        $_current_week = Carbon::now()->format('W/Y');
        $start_week = (int) Str::before($start, '/');
        $start_year = (int) Str::after($start, '/');

        $end_week = (int) Str::before($end, '/');
        $end_year = (int) Str::after($end, '/');

        $wr = false;
        $cwr = false;
        for ($y = $start_year; $y <= $end_year; $y++) {
            for ($w = 1; $w <= 52; $w++) {
                $_week = sprintf('%02s', $w) . "/$y";
                if ($start == $_week) {
                    $wr = true;
                }
                if ($_current_week == $_week) {
                    $cwr = true;
                }
                if ($wr && (in_array($_week, $exists_week) || $cwr)) {
                    array_push($weeks, $_week);
                }
                if ($end == $_week) {
                    break;
                }
            }
        }

        return $weeks;
    }
}

<?php
if (!function_exists('str_initials')) {
    /**
     * Convert a value to get only the first letter of it
     *
     * @param  string   $value
     * @return string
     */
    function str_initials($value)
    {
        return collect(preg_split("/[\s,_-]+/", $value))->map(function ($word) {
            return $word[0];
        })->join('');
    }
}

if (!function_exists('format_price')) {
    /**
     * Formats a price to a money serialization
     *
     * @param  int      $price
     * @param  string   $currency
     * @param  int      $decimal_places
     * @return string
     */
    function format_price($price, $currency = 'usd', $symbol = '$', $decimal_places = 2)
    {
        return $symbol . number_format($price, $decimal_places) . ' ' . strtoupper($currency);
    }
}

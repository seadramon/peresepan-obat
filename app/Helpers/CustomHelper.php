<?php

if (!function_exists('myRole')) {
    function myRole()
    {
        if (\Auth::user()->account_type == App\Models\Dokter::class) {
            return 'dokter';
        } elseif (\Auth::user()->account_type == App\Models\Apoteker::class) {
            return 'apoteker';
        } else {
            return 'admin';
        }
    }
} 

if (!function_exists('humanDate')) {
    function humanDate($date, $time = false)
    {
        if ($time) {
            return date('j F Y H:i',  strtotime($date));
        } else {
            return date('j F Y',  strtotime($date));
        }
    }
} 

if (!function_exists('isBetweenDates')) {
    function isBetweenDates($dateToCheck, $startDate, $endDate) 
    {
        $dateToCheck = new DateTime($dateToCheck);
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        return $dateToCheck >= $startDate && $dateToCheck <= $endDate;
    }
} 

if (!function_exists('terbilang')) {
    function terbilang($x) 
    {
        $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

        if ($x < 12) {
            return " " . $angka[$x];
        } elseif ($x < 20) {
            return terbilang($x - 10) . " belas";
        } elseif ($x < 100) {
            return terbilang($x / 10) . " puluh" . terbilang($x % 10);
        } elseif ($x < 200) {
            return "seratus" . terbilang($x - 100);
        } elseif ($x < 1000) {
            return terbilang($x / 100) . " ratus" . terbilang($x % 100);
        } elseif ($x < 2000) {
            return "seribu" . terbilang($x - 1000);
        } elseif ($x < 1000000) {
            return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
        } elseif ($x < 1000000000) {
            return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
        }
    }
} 
<?php

if (! function_exists('getCommissionFee')) {
    function getCommissionFee(&$commission, $op_amt, $fee)
    {
        if ($op_amt > -1) {
            $commission = isDecimal(number_format($fee * $op_amt, 2, '.', ''));
        } else {
            $commission = 0;
        }
    }
}


if (! function_exists('checkMaxCashIn')) {
    function checkMaxCashIn(&$commission, $max_comm)
    {
        $commission = $commission >= $max_comm ? $max_comm : $commission;
        $commission = number_format($commission, 2, '.', '');
    }
}

if (! function_exists('checkMaxCashOut')) {
    function checkMaxCashOut(&$commission, $max_comm)
    {
        $commission = $commission < $max_comm ? $max_comm : $commission;
        $commission = number_format($commission, 2, '.', '');
    }
}

if (! function_exists('isDecimal')) {
    function isDecimal($val)
    {
        return $val > 1 && is_numeric($val) && floor($val) != $val ? ceil($val) : $val;
    }
}


if (! function_exists('cleanDate')) {
    function cleanDate($date)
    {
        $date = preg_replace('/[^A-Za-z0-9\-\/]/', '', $date);
        $date = date("Y-m-d", strtotime('sunday this week', strtotime($date)));

        return $date;
    }
}
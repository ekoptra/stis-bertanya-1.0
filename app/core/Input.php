<?php

class Input
{
    public static function get($item)
    {
        if (isset($_POST[$item]))
            return trim($_POST[$item]);
        else if (isset($_GET[$item]))
            return trim($_GET[$item]);
        return '';
    }

    public static function runSanitize($value, $sanitizeType)
    {
        switch ($sanitizeType) {
            case 'int':
                $sanitizeValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                break;
            case 'string':
                $sanitizeValue = filter_var($value, FILTER_SANITIZE_STRING);
                break;
            case 'float':
                $sanitizeValue = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                break;
            case 'url':
                $sanitizeValue = filter_var($value, FILTER_SANITIZE_URL);
                break;
            case 'email':
                $sanitizeValue = filter_var($value, FILTER_SANITIZE_EMAIL);
                break;
        }
        return $sanitizeValue;
    }

    public static function generateOption($arr, $selectedValue = '')
    {
        $arrOption = "";

        foreach ($arr as $value) {
            if ($value == $selectedValue)
                $arrOption .= '<option value="' . $value . '"selected>' . $value . '</option>';
            else
                $arrOption .= '<option value="' . $value . '">' . $value . '</option>';
        }

        return $arrOption;
    }
}

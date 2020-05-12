<?php

class Validate
{
    private $error = array();
    private $formMethod = null;

    public function __construct($formMethod)
    {
        $this->formMethod = $formMethod;
    }

    public function setRules($item, $itemLabel, $rules)
    {
        if (isset($this->formMethod[$item]))
            $formValue = trim($this->formMethod[$item]);
        else
            $formValue = "";

        if (array_key_exists('sanitize', $rules)) {
            $formValue = Input::runSanitize($formValue, $rules['sanitize']);
        }

        foreach ($rules as $rule => $ruleValue) {
            switch ($rule) {
                case 'required':
                    if ($ruleValue === TRUE && empty($formValue))
                        $this->error[$item] = "{$itemLabel} tidak boleh kosong";
                    break;
                case 'numeric':
                    if ($ruleValue === TRUE && !is_numeric($formValue))
                        $this->error[$item] = "{$itemLabel} harus diisi angka";
                    break;
                case 'min_char':
                    if (strlen($formValue) < $ruleValue)
                        $this->error[$item] = "{$itemLabel} minimal {$ruleValue} karakter";
                    break;
                case 'max_char':
                    if (strlen($formValue) > $ruleValue)
                        $this->error[$item] = "{$itemLabel} maksimal {$ruleValue} karakter";
                    break;
                case 'min_value':
                    if ($formValue < $ruleValue)
                        $this->error[$item] = "{$itemLabel} minimal {$ruleValue}";
                    break;
                case 'max_value':
                    if ($formValue > $ruleValue)
                        $this->error[$item] = "{$itemLabel} maksimal {$ruleValue}";
                    break;
                case 'matches':
                    if ($formValue != $this->formMethod[$ruleValue])
                        $this->error[$item] = "{$itemLabel} tidak sama";
                    break;
                case 'email':
                    if ($ruleValue === TRUE && !filter_var($formValue, FILTER_SANITIZE_EMAIL))
                        $this->error[$item] = "Format {$itemLabel} tidak sesuai";
                    break;
                case 'url':
                    if ($ruleValue === TRUE && !filter_var($formValue, FILTER_SANITIZE_URL))
                        $this->error[$item] = "Format {$itemLabel} tidak sesuai";
                    break;
                case 'regexp':
                    if (!preg_match($ruleValue, $formValue))
                        $this->error[$item] = "Format {$itemLabel} tidak sesuai";
                    break;
                case 'spesific':
                    if ($ruleValue === TRUE && (strlen($formValue) < 8))
                        $this->error[$item] = "Judul harus spesific dan menggambarkan pertanyaan";
                    break;
                case 'jelas':
                    if ($ruleValue === TRUE && (strlen($formValue) < 15))
                        $this->error[$item] = "{$itemLabel} harus lebih diperjelas";
                    break;
                case 'unique':
                    require_once 'Database.php';
                    $db = Database::getInstance();
                    if ($db->check($ruleValue[0], $ruleValue[1], $formValue))
                        $this->error[$item] = "{$itemLabel} sudah terpakai, silahkan pilih nama lain";
            }

            if (!empty($this->error[$item]))
                break;
        }
        return $formValue;
    }

    public function getError()
    {
        return $this->error;
    }

    public function passed()
    {
        return empty($this->error) ? true : false;
    }
}

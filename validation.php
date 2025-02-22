<?php

class valid
{
    public function validLength($txt, $len)
    {
        return strlen($txt) > 1 && strlen($txt) <= $len;
    }

    public function validNIC($nic)
    {
        $final = true;
        if (!(substr($nic, strlen($nic) - 1, 1) == 'v' || substr($nic, strlen($nic) - 1, 1) == 'V')) {
            $final = false;
        }
        if (strlen($nic) == 12 || strlen($nic) == 10) {
            $final = true;
        } else {
            $final = false;
        }

        return $final;
    }

    public function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validUrl($email)
    {
        return filter_var($email, FILTER_VALIDATE_URL);
    }

    public function validINT($email)
    {
        return filter_var($email, FILTER_VALIDATE_INT);
    }

    public function validFloat($email)
    {
        return filter_var($email, FILTER_VALIDATE_FLOAT);
    }

    public function validLettersAndNumbers($txt)
    {
        return preg_match('/^[a-z0-9]+$/i', $txt);
    }

    public function validLettersNumbersAndSpace($txt)
    {
        return preg_match('/^[a-z0-9 ]+$/i', $txt);
    }

    public function validSpecialChars($txt)
    {
        return !preg_match('/^[a-z0-9]+$/i', $txt);
    }

    public function validNumbersOnly($txt)
    {
        return preg_match('/^[a-z0-9]+$/i', $txt);
    }

    public function validLettersOnly($txt)
    {
        return preg_match('/^[a-z]+$/i', $txt);
    }

    public function validPassword($pass)
    {
        if (strlen($pass) < 8) {
            return false;
        }
        if (!preg_match("/[$&@#\/%?=~_|!:,.;^*]/", $txt)) {
            return false;
        }
        if (!preg_match('/[a-z]/', $txt)) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $txt)) {
            return false;
        }
        if (!preg_match('/[0-9]/', $txt)) {
            return false;
        }

        return true;
    }
}

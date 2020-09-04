<?php

namespace App\src\Constraint;

/**
 * Class Constraint
 * @package App\src\Constraint
 */
class Constraint
{
    /**
     * @param string $name
     * @param $value
     * @return string
     */
    public function notBlank(string $name, $value)
    {
        if (empty($value)) {
            return '<p>Le champ '.$name.' saisi est vide</p>';
        }
    }

    /**
     * @param string $name
     * @param $value
     * @param int $minSize
     * @return string
     */
    public function minLength(string $name, $value, int $minSize)
    {
        if (strlen($value) < $minSize) {
            return '<p>'.$name.' field must contain at least '.$minSize.' characters</p>';
        }
    }

    /**
     * @param string $name
     * @param $value
     * @param int $maxSize
     * @return string
     */
    public function maxLength(string $name, $value, int $maxSize)
    {
        if (strlen($value) > $maxSize) {
            return '<p>'.$name.' must contain a maximum of '.$maxSize.' characters</p>';
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function isPositiveInteger($value)
    {
        if (!is_int($value + 0) || ($value +0) < 0) {
            return '<p>Please, enter a positive whole number</p>';
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function isEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return '<p>Please, enter a valid email</p>';
        }
    }

}
<?php

namespace App\Src\Constraint;

/**
 * Class Constraint
 * @package App\Src\Constraint
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
            return $name.' field is empty';
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
            return $name.' field must contain at least '.$minSize.' characters';
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
            return $name.' must contain a maximum of '.$maxSize.' characters';
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function isPositiveInteger($value)
    {
        if (!is_int($value + 0) || ($value +0) < 0) {
            return 'Please, enter a positive whole number';
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function isEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'Please, enter a valid email';
        }
    }

}
<?php

namespace App\Src\Constraint;

use App\Src\Parameter;

/**
 * Class Validation
 * @package App\Src\Constraint
 */
class Validation
{
    /**
     * @param Parameter $data
     * @param string $name
     * @return array
     */
    public function validate(Parameter $data, string $name)
    {
        if($name === 'User') {
            $userValidation = new UserValidation();
            $errors = $userValidation->check($data);
            return $errors;
        }
    }
}
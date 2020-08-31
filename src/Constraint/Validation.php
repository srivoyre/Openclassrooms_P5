<?php

namespace App\src\Constraint;

use App\src\Parameter;

/**
 * Class Validation
 * @package App\src\Constraint
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
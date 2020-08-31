<?php

namespace App\src\Constraint;

use App\src\Parameter;

/**
 * Class UserValidation
 * @package App\src\Constraint
 */
class UserValidation extends Validation
{
    private $errors = [];
    private $constraint;

    /**
     * UserValidation constructor.
     */
    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    /**
     * @param Parameter $post
     * @return array
     */
    public function check(Parameter $post)
    {
        foreach ($post->all() as $key => $value) {
            $this->checkField($key, $value);
        }

        return $this->errors;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function checkField(string $name, $value)
    {
        if ($name === 'pseudo') {
            $error = $this->checkPseudo($name, $value);
            $this->addError($name, $error);
        } elseif ($name === 'password') {
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        } elseif ($name === 'email') {
            $error = $this->checkEmail($value);
            $this->addError($name, $error);
        }
    }

    /**
     * @param string $name
     * @param $error
     */
    private function addError(string $name, $error)
    {
        if ($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    /**
     * @param string $name
     * @param $value
     * @return string
     */
    private function checkPseudo(string $name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('pseudo', $value);
        }

        if ($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('pseudo', $value, 2);
        }

        if ($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('pseudo', $value, 255);
        }
    }

    /**
     * @param string $name
     * @param $value
     * @return string
     */
    private function checkPassword(string $name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('mot de passe', $value);
        }
        if ($this->constraint->minLength($name, $value, 6)) {
            return $this->constraint->minLength('mot de passe', $value, 6);
        }
        if ($this->constraint->maxLength($name, $value, 20)) {
            return $this->constraint->maxLength('mot de passe', $value, 20);
        }
    }

    /**
     * @param $value
     * @return string
     */
    private function checkEmail($value)
    {
        if ($this->constraint->isEmail($value)) {
            return $this->constraint->isEmail($value);
        }
    }

}
<?php
namespace CineFavela\Validation;

use Respect\Validation\Validator;

class UsuarioValidator implements ValidatorInterface
{

    public function validate($object)
    {
        return isset($object->nome) && isset($object->email) && isset($object->senha) && Validator::notEmpty()->length(3, 60, true)->validate($object->nome) && Validator::notEmpty()->email()->validate($object->email) && Validator::notEmpty()->length(6, 20, true)->validate($object->senha);
    }
}
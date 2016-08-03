<?php
namespace CineFavela\Validation;

use Respect\Validation\Validator;

class FilmeValidator implements ValidatorInterface
{

    public function validate($object)
    {
        return isset($object->titulo) 
            && isset($object->sinopse) 
            && isset($object->linkYoutube) 
            && Validator::notEmpty()->length(3, 120, true)->validate($object->titulo) 
            && Validator::notEmpty()->length(140, null, true)->validate($object->sinopse) 
            && preg_match("/(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed)?(?:.*v=|v\/|\/)([\w\-_]+)\&?/", $object->linkYoutube);
    }
}
<?php
namespace CineFavela\Controller;

abstract class AbstractController
{

    public function __get($attribute)
    {
        if ($attribute == "input") {
            return json_decode(file_get_contents('php://input'));
        }
    }
}
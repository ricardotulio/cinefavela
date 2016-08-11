<?php
namespace CineFavela\Controller;

abstract class AbstractController
{

    public function __get($attribute)
    {
        if ($attribute == "request") {
            
            if (! isset($this->request)) {
                $this->request = new \stdClass();
                $this->request->input = json_decode(file_get_contents('php://input'));
                $this->request->headers = getallheaders();
            }
            
            return $this->request;
        }
    }
}
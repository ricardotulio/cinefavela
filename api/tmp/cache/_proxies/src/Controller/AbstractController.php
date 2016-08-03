<?php
namespace CineFavela\Controller;


abstract class AbstractController extends AbstractController__AopProxied implements \Go\Aop\Proxy
{

    /**
     * Property was created automatically, do not change it manually
     */
    private static $__joinPoints = [];
    
    
    public function __get($attribute)
    {
        return self::$__joinPoints['method:__get']->__invoke($this, [$attribute]);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('CineFavela\Controller\AbstractController',array (
  'method' => 
  array (
    '__get' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
  ),
));
<?php
namespace CineFavela\Controller;

use CineFavela\Repository\FilmeRepository as FilmeRepository;
use CineFavela\Validation\ValidatorInterface as ValidatorInterface;
use Respect\Rest\Routable as Routable;
use CineFavela\Model\Filme as Filme;
use CineFavela\Repository\SessaoRepository as SessaoRepository;

class FilmeController extends FilmeController__AopProxied implements \Go\Aop\Proxy
{

    /**
     * Property was created automatically, do not change it manually
     */
    private static $__joinPoints = [];
    
    
    public function get($id = NULL)
    {
        return self::$__joinPoints['method:get']->__invoke($this, \array_slice([$id], 0, \func_num_args()));
    }
    
    
    public function post()
    {
        return self::$__joinPoints['method:post']->__invoke($this);
    }
    
    
    public function __get($attribute)
    {
        return self::$__joinPoints['method:__get']->__invoke($this, [$attribute]);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('CineFavela\Controller\FilmeController',array (
  'method' => 
  array (
    'get' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
    'post' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
    '__get' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
  ),
));
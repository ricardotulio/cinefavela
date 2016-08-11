<?php
namespace CineFavela\Controller;

use CineFavela\Model\Usuario as Usuario;
use CineFavela\Repository\UsuarioRepository as UsuarioRepository;
use CineFavela\Validation\ValidatorInterface as ValidatorInterface;
use Respect\Rest\Routable as Routable;

final class UsuarioController extends UsuarioController__AopProxied implements \Go\Aop\Proxy
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
    
    
    public function put($id)
    {
        return self::$__joinPoints['method:put']->__invoke($this, [$id]);
    }
    
    
    public function delete($id)
    {
        return self::$__joinPoints['method:delete']->__invoke($this, [$id]);
    }
    
    
    public function __get($attribute)
    {
        return self::$__joinPoints['method:__get']->__invoke($this, [$attribute]);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('CineFavela\Controller\UsuarioController',array (
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
    'put' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
    'delete' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
    '__get' => 
    array (
      0 => 'advisor.CineFavela\\Aspect\\AutorizadorAspect->beforeMethodExecution',
    ),
  ),
));
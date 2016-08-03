<?php
namespace CineFavela\Controller;

use Respect\Rest\Routable as Routable;
use CineFavela\Repository\UsuarioRepository as UsuarioRepository;
use CineFavela\Model\Sessao as Sessao;
use CineFavela\Repository\SessaoRepository as SessaoRepository;

class AutenticacaoController extends AutenticacaoController__AopProxied implements \Go\Aop\Proxy
{

    /**
     * Property was created automatically, do not change it manually
     */
    private static $__joinPoints = [];
    
    
    public function post()
    {
        return self::$__joinPoints['method:post']->__invoke($this);
    }
    
    
    public function __get($attribute)
    {
        return self::$__joinPoints['method:__get']->__invoke($this, [$attribute]);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('CineFavela\Controller\AutenticacaoController',array (
  'method' => 
  array (
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
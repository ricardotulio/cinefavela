<?php
namespace CineFavela\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;

class AutorizadorAspect implements Aspect
{
    /**
     * @Before("!execution(public CineFavela\Controller\*Controller->__construct(*)) && execution(public CineFavela\Controller\*Controller->*(*))")
     */
    public function beforeMethodExecution(MethodInvocation $invocation)
    {
    }
}
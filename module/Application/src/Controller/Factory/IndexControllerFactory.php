<?php 

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {   
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        
        return new IndexController($authService);
    }
}
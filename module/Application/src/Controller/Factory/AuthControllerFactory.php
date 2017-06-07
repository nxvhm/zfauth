<?php 

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\AuthController;
use Application\Service\UserManager;
use Application\Service\AuthManager;

class AuthControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {   
        $authManager = $container->get(AuthManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $userManager = $container->get(UserManager::class);
        
        return new AuthController($authManager, $authService, $userManager);
    }
}
<?php 

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\UsersController;
use Application\Service\UserManager;

class UsersControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
    	
        $manager = $container->get(UserManager::class);
        
        return new UsersController($manager);
    }
}

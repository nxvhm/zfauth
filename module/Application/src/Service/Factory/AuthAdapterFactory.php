<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Application\Service\AuthAdapter;
use Zend\ServiceManager\Factory\FactoryInterface;


class AuthAdapterFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');        
                        
        # Create the AuthAdapter and inject dependency to its constructor.
        return new AuthAdapter($entityManager);
    }
}
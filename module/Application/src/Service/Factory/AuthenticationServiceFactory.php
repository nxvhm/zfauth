<?php 

namespace Application\Service\Factory;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Application\Service\AuthAdapter;



class AuthenticationServiceFactory implements FactoryInterface
{
	/**
	 * create and config the Zend\Authentication\AuthenticationService and return instance 
	 * @param  ContainerInterface $container     [description]
	 * @param  [type]             $requestedName [description]
	 * @param  array|null         $ops           [description]
	 * @return Zend\Authentication\AuthenticationService [description]
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $ops = null) {

		# Create session storage with session driver
		$authStorage = new SessionStorage(
			'Zend_Auth', 
			'session', 
			$container->get(SessionManager::class)
		);

		return new AuthenticationService($authStorage,  $container->get(AuthAdapter::class)); 
	}
}
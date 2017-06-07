<?php 

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Application\Service\UserManager;

class UserManagerFactory {
	public function __invoke(ContainerInterface $container) {
		$entityManager = $container->get('doctrine.entitymanager.orm_default');

		return new UserManager($entityManager);
	}
}
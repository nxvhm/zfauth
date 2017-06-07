<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;

class UsersController extends AbstractActionController
{

    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $userManager;   

    public function __construct($userManager) {
    	$this->userManager = $userManager;
    }

    public function listAction()
    {	
    	$view = new ViewModel();

    	$view->user = (bool) $this->identity();
    	if ($view->user) {

            $view->members = $this->userManager->getUsers();	
    	}

    	return $view;
    }
}

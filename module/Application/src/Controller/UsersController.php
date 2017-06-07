<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

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

            # Get page param, default value 1
            $page = $this->params()->fromRoute('page');
            $page = $page < 1 ? 1 : $page;

            $query = $this->userManager->getUsersQuery();

            $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
            
            $view->members = new Paginator($adapter);
            
            $view->members->setDefaultItemCountPerPage(2);  
            
            $view->members->setCurrentPageNumber($page);

            $view->paginationData = $view->members->getPages();

    	}

    	return $view;
    }
}

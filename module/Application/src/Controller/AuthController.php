<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Application\Form\Signup as SignupForm;
use Application\Form\Login as LoginForm;

class AuthController extends AbstractActionController
{

    /**
     * Auth manager.
     * @var Application\Service\AuthManager 
     */
    private $authManager;    


    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;
    
    /**
     * User manager.
     * @var Application\Service\UserManager
     */
    private $userManager;


    public function __construct($authManager, $authService, $userManager) {
        $this->authManager = $authManager;
        $this->authService = $authService;
        $this->userManager = $userManager;
    } 


    /**
     * Display and process Login form 
     * @return ViewModel
     */    
    public function loginFormAction()
    {

        $view = new ViewModel();

        $view->form = new LoginForm();

        $view->messages = [];

        if ($this->flashMessenger()->hasMessages()) {
            $view->messages = $this->flashMessenger()->getMessages();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = $this->params()->fromPost();

            $view->form->setData($data);

            if ($view->form->isValid()) {

                $validatedData = $view->form->getData();

                $exists = $this->userManager->checkUserExists($validatedData['email']);

                if ($exists) {

                    $authRes = $this->authManager->login($validatedData);

                    if ($authRes->getCode() == Result::SUCCESS) {

                        return $this->redirect()->toRoute('members');
                        
                    } else if ($authRes->getCode() == Result::FAILURE_CREDENTIAL_INVALID) {
                        
                        $view->errorMsg = $authRes->getMessages();
                    }

                } else {
                    $view->errorMsg = "User with email ".$validatedData['email'] . " doesnt exist";
                }
            }
        }

        return $view;
    }

    /**
     * Display and process Signup form 
     * @return ViewModel $view
     */
    public function signupFormAction()
    {
        $view = new ViewModel();

        $view->form = new SignupForm();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $data = $this->params()->fromPost();

          $view->form->setData($data);

          if ($view->form->isValid()) {

            $validatedData = $view->form->getData();

            $exists = $this->userManager->checkUserExists($validatedData['email']);

            if (!$exists) {
                $user = $this->userManager->addUser($validatedData);

                if ($user) {
                    $this->flashMessenger()->addMessage('Successfull registration. You can now log in.');
                    return $this->redirect()->toRoute('loginForm');
                }

            }

            $view->userExists = true;

          }

        }

       return $view;
    }    

    public function logoutAction() {

        if ($this->authService->hasIdentity()) {
            $this->authManager->logout();
        }

        return $this->redirect()->toRoute('home');    	
    }

}

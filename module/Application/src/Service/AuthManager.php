<?php
namespace Application\Service;

use Zend\Authentication\Result;

class AuthManager
{
    /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;
    
    /**
     * Session manager.
     * @var Zend\Session\SessionManager
     */
    private $sessionManager;
    
    /**
     * Contents of the 'access_filter' config key.
     * @var array 
     */
    private $config;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $sessionManager, $config) 
    {
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }
    
    
    public function login($data, $rememberMe = false)
    {   

        if ($this->authService->getIdentity()!=null) {
            throw new \Exception('Already logged in');
        }
            
        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setEmail($data['email']);
        $authAdapter->setPassword($data['password']);
        $result = $this->authService->authenticate();
        

        /**
         * If user wants to "remember him", we will make session to expire in 
         * two weeks. 
         * By default session expires in 1 hour (as specified in our config/global.php file).
        */
        if ($result->getCode()==Result::SUCCESS && $rememberMe) {
            # Session cookie will expire in 14 days
            $this->sessionManager->rememberMe(60*60*24*14);
        }
        
        return $result;
    }
    
    /**
     * Performs user logout.
     */
    public function logout()
    {
        // Allow to log out only when user is logged in.
        if ($this->authService->getIdentity()==null) {
            throw new \Exception('The user is not logged in');
        }
        
        // Remove identity from session.
        $this->authService->clearIdentity();               
    }
    
    /**
     * This is a simple access control filter. It is able to restrict unauthorized
     * users to visit certain pages.
     * 
     * This method uses the 'access_filter' key in the config file and determines
     * whenther the current visitor is allowed to access the given controller action
     * or not. It returns true if allowed; otherwise false.
     */
    public function filterAccess($controllerName, $actionName)
    {
        $mode = isset($this->config['options']['mode'])?$this->config['options']['mode']:'restrictive';
        if ($mode!='restrictive' && $mode!='permissive')
            throw new \Exception('Invalid access filter mode (expected either restrictive or permissive mode');
        
        if (isset($this->config['controllers'][$controllerName])) {
            $items = $this->config['controllers'][$controllerName];
            foreach ($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];
                if (is_array($actionList) && in_array($actionName, $actionList) ||
                    $actionList=='*') {
                    if ($allow=='*')
                        return true; // Anyone is allowed to see the page.
                    else if ($allow=='@' && $this->authService->hasIdentity()) {
                        return true; // Only authenticated user is allowed to see the page.
                    } else {                    
                        return false; // Access denied.
                    }
                }
            }            
        }
        
        // In restrictive mode, we forbid access for unauthorized users to any 
        // action not listed under 'access_filter' key (for security reasons).
        if ($mode=='restrictive' && !$this->authService->hasIdentity())
            return false;
        
        // Permit access to this page.
        return true;
    }
}
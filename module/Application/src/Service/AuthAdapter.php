<?php 

namespace Application\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Application\Entity\User;

class AuthAdapter implements AdapterInterface
{
    /**
     * User email.
     * @var string 
     */
    private $email;
    
    /**
     * Password
     * @var string 
     */
    private $password;

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }        

    /**
     * Sets user email.     
     */
    public function setEmail($email) 
    {
        $this->email = $email;        
    }
    
    /**
     * Sets password.     
     */
    public function setPassword($password) 
    {
        $this->password = (string)$password;        
    }    


 	/**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {                
        # Check the database if there is a user with such email.
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->email);
        
        # If there is no such user, return 'Identity Not Found' status.
        if ($user == null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND, 
                null, 
                ['Invalid credentials.']);        
        }   
        
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();
        
        if ($bcrypt->verify($this->password, $passwordHash)) {
            # The password hash matches. Return user identity data to be stored in session 
            return new Result(
                    Result::SUCCESS, 
                    [
                        'email' => $this->email,
                        'username' => $user->getUsername(),
                        'id' => $user->getId()
                    ],
                    ['Authenticated successfully.']);        
        }             
        
        # If password check didn't pass return 'Invalid Credential'
        return new Result(
                Result::FAILURE_CREDENTIAL_INVALID, 
                null, 
                ['Invalid credentials.']);        
    }    
}
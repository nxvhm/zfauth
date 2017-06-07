<?php 

namespace Application\Service;

use Application\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;

class UserManager {

   	/**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;  


    /**
     * Constructs the service.
     * @param [type] $entityManager [description]
     */
    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }    

    /**
     * Checks if user with given email already exists in db.  
     * @param $email string  
     * @return bool 
     */
    public function checkUserExists($email) {
        
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);
        
        return $user !== null;
    }   

    /**
     * Checks that the given password is correct.
     * @param  Application\Entity\User $user
     * @param  string $password pass to match
     * @return bool
     */
    public function validatePassword($user, $password) 
    {
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();
        
        if ($bcrypt->verify($password, $passwordHash)) {
            return true;
        }
        
        return false;
    }    
    /**
     * Add new user record in db
     * @param array $data User data
     */
    public function addUser($data) {
    	
        # Do not allow several users with the same email address.
        if($this->checkUserExists($data['email'])) {
            throw new \Exception("User with email address " . $data['$email'] . " already exists");
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);

        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);        
        $user->setPassword($passwordHash);
                
        $currentDate = date('Y-m-d H:i:s');
        $user->setCreatedAt($currentDate);        
                
        # Add the entity to the entity manager.
        $this->entityManager->persist($user);
        
        # Apply changes to database.
        $this->entityManager->flush();
        
        return $user;        
    } 

    /**
     * Get query object to be used for pagination
     * adapter
     * @return Doctrine\ORM\Query $query
     */
    public function getUsersQuery() {
        $em = $this->entityManager;

        $query = $em->createQueryBuilder();

        $query->select('users')->from(User::class, 'users');

        return $query->getQuery();
    }
}
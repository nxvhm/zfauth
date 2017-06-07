<?php  

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registered user model
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
	protected $id;


    /** 
     * @ORM\Column(name="email")  
     */
    protected $email;

    /** 
     * @ORM\Column(name="username")  
     */
    protected $username;
    
   	/** 
     * @ORM\Column(name="password")  
     */
    protected $password;

    /**
     * @ORM\Column(name="created_at")  
     */
    protected $createdAt;


    /**
     * Returns user ID.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }


    /**
     * Sets user ID. 
     * @param int $id    
     */
    public function setId($id) 
    {
        $this->id = $id;
    }


    /**
     * Returns email.     
     * @return string
     */
    public function getEmail() 
    {
        return $this->email;
    }


    /**
     * Sets email.     
     * @param string $email
     */
    public function setEmail($email) 
    {
        $this->email = $email;
    } 


    /**
     * Sets username.     
     * @param string $username
     */
    public function setUsername($username) 
    {
        $this->username = $username;
    }
    /**
     * Returns username.     
     * @return string
     */
    public function getUsername() 
    {
        return $this->username;
    }

   
 /**
     * Returns password.
     * @return string
     */
    public function getPassword() 
    {
       return $this->password; 
    }
    
    /**
     * Sets password.     
     * @param string $password
     */
    public function setPassword($password) 
    {
        $this->password = $password;
    }
    
    /**
     * Returns the date of user creation.
     * @return string     
     */
    public function getCreatedAt() 
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the date when this user was created.
     * @param string $dateCreated     
     */
    public function setCreatedAt($createdAt) 
    {
        $this->createdAt = $createdAt;
    }    

}
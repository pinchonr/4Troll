<?php 

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
	private $roles=[];
	private $surname;
	private $name;
	private $pseudo;
	private $password
	private $email;

	public function getRoles(){
		return $this->roles;
	}

    public function getPassword(){
    	return $this->password;
    }
   
    public function getSalt(){
    	return $this->salt;
    }
    
    public function getName(){
    	return $this->name;
    }

    public function getSurname(){
    	return $this->surname;
    }

    public function getEmail(){
    	return $this->email;
    }

    public function getPseudo(){
    	return $this->pseudo;
    }
    
    public function eraseCredentials(){

    }
}

?>
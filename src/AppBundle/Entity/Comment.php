<?php

namespace AppBundle\Entity;

class Comment
{
	private message;
	private date;
	private Gag;
    private User;

	public function getMessage(){
		return $this->message;
    }

    public function getUser(){
    	return $this->user;
    }

    public function getLastModifiedDate(){
        return $this->date;
    }
    	

}

?>
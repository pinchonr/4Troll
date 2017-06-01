<?php

namespace AppBundle\Entity;

class VoteGag
{
	private Gag;
    private User;
    private updown;

    public function getGag(){
        return $this->Gag;
    }

    public function getUser(){
        return $this->User;
    }

    public function getUpdown(){
        return $this->updown;
    }

}

?>
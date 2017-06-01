<?php

namespace AppBundle\Entity;

class Gag
{
	private title;
    private filename;
    private lastModifiedDate;
    private user;

    public function getTitle(){
        return $this->title;
    }

    public function getFilename(){
        return $this->filename;
    }

    public function getLastModifiedDate(){
        return $this->lastModifiedDate;
    }

    public function getUser() {
        return $this->user;
    }

}

?>
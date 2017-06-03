<?php

namespace AppBundle\Entity;

/**
 * VoteGag
 */
class VoteGag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \stdClass
     */
    private $gag;

    /**
     * @var \stdClass
     */
    private $user;

    /**
     * @var bool
     */
    private $updown;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gag
     *
     * @param \stdClass $gag
     *
     * @return VoteGag
     */
    public function setGag($gag)
    {
        $this->gag = $gag;

        return $this;
    }

    /**
     * Get gag
     *
     * @return \stdClass
     */
    public function getGag()
    {
        return $this->gag;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return VoteGag
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set updown
     *
     * @param boolean $updown
     *
     * @return VoteGag
     */
    public function setUpdown($updown)
    {
        $this->updown = $updown;

        return $this;
    }

    /**
     * Get updown
     *
     * @return bool
     */
    public function getUpdown()
    {
        return $this->updown;
    }
}


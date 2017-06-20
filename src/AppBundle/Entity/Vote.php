<?php

namespace AppBundle\Entity;

/**
 * Vote
 */
class Vote
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Gag
     */
    private $gag;

    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $upVote= false;

    /**
     * @var bool
     */
    private $downVote= false;


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
     * @param Gag $gag
     *
     * @return VoteGag
     */
    public function setGag(Gag $gag)
    {
        $this->gag = $gag;
    }

    /**
     * Get gag
     *
     * @return Gag
     */
    public function getGag()
    {
        return $this->gag;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Vote
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get updown
     *
     * @return bool
     */
    public function getUpVote()
    {
        return $this->upVote;
    }

    /**
     * Set upVotes
     *
     * @param boolean $updown
     *
     * @return Vote
     */
    public function setUpVote()
    {
        $this->upVote = true;
    }

    /**
     * Get updown
     *
     * @return bool
     */
    public function getDownVote()
    {
        return $this->downVote;
    }

    /**
     * Set upVotes
     *
     * @param boolean $updown
     *
     * @return Vote
     */
    public function setDownVote()
    {
        $this->downVote = true;
    }
}

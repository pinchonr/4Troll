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
     * @var string
     */
    private $vote;

    public function __construct()
    {
        $this->vote = null;
    }

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
     * Get isUpVote
     *
     * @return string
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set isUpVote
     *
     * @param string $vote
     *
     * @return Vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
    }
}

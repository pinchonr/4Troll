<?php

namespace AppBundle\Entity;

/**
 * Comment
 */
class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \stdClass
     */
    private $gag;

    /**
     * @var \stdClass
     */
    private $user;


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
     * Set message
     *
     * @param string $message
     *
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
     */
    public function setDate()
    {
        $this->date = new \DateTime('now');

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set gag
     *
     * @param \stdClass $gag
     *
     * @return Comment
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
     * @return Comment
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
}


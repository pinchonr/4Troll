<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Gag
 */
class Gag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var User
     */
    private $author;

    /**
     * @var ArrayCollection
     */
    private $comments;

    /**
     * @var ArrayCollection
     */
    private $votes;
    

    public function __construct()
    {
        $this->lastModified = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->votes = new ArrayCollection();
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Get file name
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set file name
     *
     * @param string
     */
    public function setFileName($name)
    {
        $this->fileName = $name;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * Get the author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
    * Get all comments
    */
    public function getComments()
    {
        return $this->comments;
    }

    /**
    * Add a new Comment
    */
    public function addComment(Comment $comment)
    {
        $comment->setGag($this);
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }
    /**
    * Remove a comment
    */
    public function removeComment(Comment $comment)
    {
        $comment->setGag(null);
        $this->comments->removeElement($comment);
    }

    /**
    * Get all votes
    */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
    * Add a new Comment
    */
    public function addVote(Vote $vote)
    {
        $vote->setGag($this);
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
        }
    }

    /**
    * Remove a comment
    */
    public function removeVote(Vote $vote)
    {
        $vote->setGag(null);
        $this->votes->removeElement($vote);
    }

    /**
    *Get the absolute path of the file
    *
    *@return string
    */
    public function getAbsolutePath()
    {
        return null === $this->fileName
            ? null
            : $this->getUploadRootDir().'/'.$this->fileName;
    }

    /**
     * Get the web path of the file
     *
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->fileName
            ? null
            : $this->getUploadDir().'/'.$this->fileName;
    }

    /**
     * Get the upload root directory of the file
     *
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     * Get the upload directory of the file
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/gags';
    }
}

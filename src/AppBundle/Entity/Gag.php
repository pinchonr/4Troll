<?php

namespace AppBundle\Entity;

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
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var \stdClass
     */
    private $user;

    /**
     * @var string
     */
    private $fileName;


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
     * Set title
     *
     * @param string $title
     *
     * @return Gag
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set lastModified
     *
     * @param \DateTime $lastModified
     *
     * @return Gag
     */
    public function setLastModified()
    {
        $this->lastModified = new \DateTime('now');

        return $this;
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
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Gag
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

    /**
     * Get file name
     *
     * @return fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set file name
     *
     * @param name
     *
     * @return Gag
     */
    public function setFileName($name)
    {
        $this->fileName = $name;

        return $this;
    }

}


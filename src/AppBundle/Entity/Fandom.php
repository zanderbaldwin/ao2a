<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="fandoms")
 * @ORM\HasLifecycleCallbacks
 */
class Fandom
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Media")
     * @ORM\JoinColumn(name="media", nullable=false)
     * @var \AppBundle\Entity\Media
     */
    protected $media;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="datetime", name="created_on")
     * @var \DateTime
     */
    protected $createdOn;

    /**
     * @ORM\Column(type="datetime", name="updated_on", nullable=true)
     * @var \DateTime
     */
    protected $updatedOn;

    /**
     * @param  \Ramsey\Uuid\Uuid $id
     */
    public function __construct(Uuid $id = null)
    {
        $this->id = $id ?: Uuid::uuid4();
    }

    /**
     * @return \Ramsey\Uuid\Uuid
     */
    public function getUuid()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * @return \AppBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param \AppBundle\Entity\Media $media
     * @return void
     */
    public function setMedia(Media $media)
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @ORM\PrePersist
     * @param  \DateTime $datetime
     * @return void
     */
    public function setCreatedOn(\DateTime $datetime = null)
    {
        $this->createdOn = $datetime ?: new \DateTime;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @ORM\PreUpdate
     * @param  \DateTime $datetime
     * @return void
     */
    public function setUpdatedOn(\DateTime $datetime = null)
    {
        $this->updatedOn = $datetime ?: new \DateTime;
    }
}

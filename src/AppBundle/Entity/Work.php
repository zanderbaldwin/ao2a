<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="works")
 */
class Work
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @var \Ramsey\Uuid\Uuid
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Fandom")
     * @ORM\JoinColumn(name="fandom")
     * @var \AppBundle\Entity\Fandom
     */
    protected $fandom;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Author")
     * @ORM\JoinColumn(name="author")
     * @var \AppBundle\Entity\Author
     */
    protected $author;

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
     * @return string
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * @return \AppBundle\Entity\Fandom
     */
    public function getFandom()
    {
        return $this->fandom;
    }

    /**
     * @param \AppBundle\Entity\Fandom $fandom
     * @return void
     */
    public function setFandom(Fandom $fandom)
    {
        $this->fandom = $fandom;
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
     * @return \AppBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param \AppBundle\Entity\Author $author
     * @return void
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }
}

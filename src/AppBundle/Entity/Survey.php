<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Survey
 *
 * @ORM\Table(name="survey")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SurveyRepository")
 */
class Survey
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Headquarter", inversedBy="survey")
     */
    private $headquarter;

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return Survey
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set headquarter
     *
     * @param string $headquarter
     *
     * @return Survey
     */
    public function setHeadquarter($headquarter)
    {
        $this->headquarter = $headquarter;

        return $this;
    }

    /**
     * Get headquarter
     *
     * @return string
     */
    public function getHeadquarter()
    {
        return $this->headquarter;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->headquarter = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add headquarter
     *
     * @param \AppBundle\Entity\Headquarter $headquarter
     *
     * @return Survey
     */
    public function addHeadquarter(\AppBundle\Entity\Headquarter $headquarter)
    {
        $this->headquarter[] = $headquarter;

        return $this;
    }

    /**
     * Remove headquarter
     *
     * @param \AppBundle\Entity\Headquarter $headquarter
     */
    public function removeHeadquarter(\AppBundle\Entity\Headquarter $headquarter)
    {
        $this->headquarter->removeElement($headquarter);
    }
}

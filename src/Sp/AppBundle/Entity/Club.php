<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 12:09
 */


namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\ClubRepository")
 * @ORM\Table(name="club")
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Club title cannot be longer than {{ limit }} characters length"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Swimmer", mappedBy="club")
     */
    private $swimmers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->swimmers = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Club
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
     * Add swimmers
     *
     * @param Swimmer $swimmer
     * @return Club
     */
    public function addSwimmer(Swimmer $swimmer)
    {
        $this->swimmers[] = $swimmer;

        return $this;
    }

    /**
     * Remove swimmer
     *
     * @param Swimmer $swimmer
     */
    public function removeSwimmer(Swimmer $swimmer  )
    {
        $this->swimmers->removeElement($swimmer);
    }

    /**
     * Get swimmers
     *
     * @return Collection
     */
    public function getSwimmers()
    {
        return $this->swimmers;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}
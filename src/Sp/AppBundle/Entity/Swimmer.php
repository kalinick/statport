<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:12
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\SwimmerRepository")
 * @ORM\Table(name="swimmer")
 */
class Swimmer
{
    /**
     * @Assert\NotBlank()
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Swimmer first name be longer than {{ limit }} characters length"
     * )
     * @ORM\Column(type="string", name="first_name", length=255)
     */
    private $firstName;

    /**
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Swimmer last name cannot be longer than {{ limit }} characters length"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", name="last_name", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", name="middle_name", length=255)
     */
    private $middleName;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"M", "F"}, message = "Choose a valid gender.")
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="swimmers")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    /**
     * @ORM\Column(name="club_entered_date", type="date", nullable=true)
     */
    private $clubEnteredDate;

    /**
     * @ORM\OneToMany(targetEntity="EventResult", mappedBy="swimmer")
     */
    private $results;

    /**
     * @ORM\OneToMany(targetEntity="UserChild", mappedBy="swimmer")
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Swimmer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Swimmer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     * @return Swimmer
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    
        return $this;
    }

    /**
     * Get middleName
     *
     * @return string 
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Add results
     *
     * @param EventResult $results
     * @return Swimmer
     */
    public function addResult(EventResult $results)
    {
        $this->results[] = $results;
    
        return $this;
    }

    /**
     * Remove results
     *
     * @param EventResult $results
     */
    public function removeResult(EventResult $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return EventResult[]
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Swimmer
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLastName() . ' ' . $this->getFirstName();
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Swimmer
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return string
     */
    public function toStringGenderAge()
    {
        $str = ($this->getGender() == 'M') ? 'Boys' : 'Girls';
        $age = (int) $this->getBirthday()->diff(new \DateTime())->format('%y');
        if ($age < 11) {
            $str  = $str . ' 10&Under';
        } else if ($age < 13 ) {
            $str = $str . ' 11-12';
        } else if ($age < 15 ) {
            $str = $str . ' 13-14';
        } else if ($age < 17 ) {
            $str = $str . ' 15-16';
        } else if ($age < 19 ) {
            $str = $str . ' 17-18';
        } else {
            $str  = $str . ' 19&Older';
        }
        return $str;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Swimmer
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Set club
     *
     * @param Club $club
     * @return Swimmer
     */
    public function setClub(Club $club)
    {
        $this->club = $club;
    
        return $this;
    }

    /**
     * Get club
     *
     * @return Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Set clubEnteredDate
     *
     * @param \DateTime $clubEnteredDate
     * @return Swimmer
     */
    public function setClubEnteredDate($clubEnteredDate)
    {
        $this->clubEnteredDate = $clubEnteredDate;
    
        return $this;
    }

    /**
     * Get clubEnteredDate
     *
     * @return \DateTime 
     */
    public function getClubEnteredDate()
    {
        return $this->clubEnteredDate;
    }

    /**
     * Add children
     *
     * @param UserChild $children
     * @return Swimmer
     */
    public function addChildren(UserChild $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param UserChild $children
     */
    public function removeChildren(UserChild $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
}
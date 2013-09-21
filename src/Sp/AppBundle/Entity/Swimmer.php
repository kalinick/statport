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

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\SwimmerRepository")
 * @ORM\Table(name="swimmer")
 */
class Swimmer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="first_name", length=255)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", name="last_name", length=255)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", name="middle_name", length=255)
     */
    protected $middleName;

    /**
     * @ORM\Column(type="string", length=1)
     */
    protected $gender;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthday;

    /**
     * @ORM\OneToMany(targetEntity="EventResult", mappedBy="swimmer")
     */
    private $results;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new ArrayCollection();
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
     * @return Collection
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
    public function setBirthday($birthday)
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
}
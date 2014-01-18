<?php
/**
 * User: Nikita
 * Date: 19.11.13
 * Time: 21:14
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="state")
 */
class State
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="UserProfile", mappedBy="state")
     */
    private $userProfile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userProfile = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return State
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return State
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
     * Add userProfile
     *
     * @param UserProfile $userProfile
     * @return State
     */
    public function addUserProfile(UserProfile $userProfile)
    {
        $this->userProfile[] = $userProfile;
    
        return $this;
    }

    /**
     * Remove userProfile
     *
     * @param UserProfile $userProfile
     */
    public function removeUserProfile(UserProfile $userProfile)
    {
        $this->userProfile->removeElement($userProfile);
    }

    /**
     * Get userProfile
     *
     * @return Collection
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
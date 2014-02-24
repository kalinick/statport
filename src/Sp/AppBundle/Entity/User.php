<?php
/**
 * User: Nikita
 * Date: 11.11.13
 * Time: 23:03
 */

namespace Sp\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserProfile", mappedBy="user", cascade={"all"})
     *
     **/
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="UserChild", mappedBy="user", cascade={"all"})
     */
    private $children;

    public function __construct()
    {
        parent::__construct();
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
     * Set profile
     *
     * @param UserProfile $profile
     * @return User
     */
    public function setProfile(UserProfile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return UserProfile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Add children
     *
     * @param UserChild $children
     * @return User
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
     * @return \Doctrine\Common\Collections\Collection|UserChild[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}
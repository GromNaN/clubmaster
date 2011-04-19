<?php

namespace Club\UserBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\Group")
 * @orm:Table(name="club_group")
 */
class Group
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
     * @var string $group_name
     */
    private $group_name;

    /**
     * @orm:Column(type="string")
     *
     * @var string $group_type
     */
    private $group_type;

    /**
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $gender
     */
    private $gender;

    /**
     * @orm:Column(type="integer", nullable="true")
     *
     * @var integer $min_age
     */
    private $min_age;

    /**
     * @orm:Column(type="integer", nullable="true")
     *
     * @var integer $max_age
     */
    private $max_age;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $is_active
     */
    private $is_active;

    /**
     * @orm:ManyToOne(targetEntity="Group")
     *
     * @var Club\UserBundle\Entity\Group
     */
    private $group;

    /**
     * @orm:ManyToMany(targetEntity="Role")
     *
     * @var Club\UserBundle\Entity\Role
     */
    private $role;

    /**
     * @orm:ManyToMany(targetEntity="Location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $location;

    /**
     * @orm:ManyToMany(targetEntity="User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set group_name
     *
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->group_name = $groupName;
    }

    /**
     * Get group_name
     *
     * @return string $groupName
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * Set group_type
     *
     * @param string $groupType
     */
    public function setGroupType($groupType)
    {
        $this->group_type = $groupType;
    }

    /**
     * Get group_type
     *
     * @return string $groupType
     */
    public function getGroupType()
    {
        return $this->group_type;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set min_age
     *
     * @param integer $minAge
     */
    public function setMinAge($minAge)
    {
        $this->min_age = $minAge;
    }

    /**
     * Get min_age
     *
     * @return integer $minAge
     */
    public function getMinAge()
    {
        return $this->min_age;
    }

    /**
     * Set max_age
     *
     * @param integer $maxAge
     */
    public function setMaxAge($maxAge)
    {
        $this->max_age = $maxAge;
    }

    /**
     * Get max_age
     *
     * @return integer $maxAge
     */
    public function getMaxAge()
    {
        return $this->max_age;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get is_active
     *
     * @return boolean $isActive
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set group
     *
     * @param Club\UserBundle\Entity\Group $group
     */
    public function setGroup(\Club\UserBundle\Entity\Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get group
     *
     * @return Club\UserBundle\Entity\Group $group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add role
     *
     * @param Club\UserBundle\Entity\Role $role
     */
    public function addRole(\Club\UserBundle\Entity\Role $role)
    {
        $this->role[] = $role;
    }

    /**
     * Get role
     *
     * @return Doctrine\Common\Collections\Collection $role
     */
    public function getRole()
    {
        return $this->role;
    }
}

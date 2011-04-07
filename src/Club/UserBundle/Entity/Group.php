<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\Group
 */
class Group
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $group_name
     */
    private $group_name;

    /**
     * @var string $group_type
     */
    private $group_type;

    /**
     * @var string $sex
     */
    private $sex;

    /**
     * @var integer $min_age
     */
    private $min_age;

    /**
     * @var integer $max_age
     */
    private $max_age;

    /**
     * @var boolean $is_active
     */
    private $is_active;

    /**
     * @var Club\UserBundle\Entity\Group
     */
    private $group;

    /**
     * @var Club\UserBundle\Entity\Role
     */
    private $role;

    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set sex
     *
     * @param string $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * Get sex
     *
     * @return string $sex
     */
    public function getSex()
    {
        return $this->sex;
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
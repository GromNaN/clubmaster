<?php

namespace Club\UserBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\ProfileEmail")
 * @orm:Table(name="club_profile_email")
 */
class ProfileEmail
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
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $email_address
     */
    private $email_address;

    /**
     * @orm:Column(type="string")
     *
     * @var string $contact_type
     */
    private $contact_type;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $is_default
     */
    private $is_default;

    /**
     * @orm:ManyToOne(targetEntity="Profile")
     *
     * @var Club\UserBundle\Entity\Profile
     */
    private $profile;


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
     * Set email_address
     *
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->email_address = $emailAddress;
    }

    /**
     * Get email_address
     *
     * @return string $emailAddress
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Set contact_type
     *
     * @param string $contactType
     */
    public function setContactType($contactType)
    {
        $this->contact_type = $contactType;
    }

    /**
     * Get contact_type
     *
     * @return string $contactType
     */
    public function getContactType()
    {
        return $this->contact_type;
    }

    /**
     * Set is_default
     *
     * @param boolean $isDefault
     */
    public function setIsDefault($isDefault)
    {
        $this->is_default = $isDefault;
    }

    /**
     * Get is_default
     *
     * @return boolean $isDefault
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    /**
     * Set profile
     *
     * @param Club\UserBundle\Entity\Profile $profile
     */
    public function setProfile(\Club\UserBundle\Entity\Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Get profile
     *
     * @return Club\UserBundle\Entity\Profile $profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}

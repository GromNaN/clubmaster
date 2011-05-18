<?php

namespace Club\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\User")
 * @orm:Table(name="club_user")
 * @orm:HasLifecycleCallbacks()
 */
class User implements UserInterface
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
     * @assert:NotBlank()
     *
     * @var string $username
     */
    private $username;

    /**
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $password
     */
    private $password;

    /**
     * @orm:Column(type="datetime", nullable="true")
     *
     * @var date $last_login_time
     */
    private $last_login_time;

    /**
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $last_login_ip
     */
    private $last_login_ip;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $enabled
     */
    private $enabled;

    /**
     * @orm:Column(type="string")
     *
     * @var string $algorithm
     */
    private $algorithm;

    /**
     * @orm:Column(type="string")
     *
     * @var string $salt
     */
    private $salt;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $locked
     */
    private $locked;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $expired
     */
    private $expired;

    /**
     * @orm:Column(type="datetime", nullable="true")
     *
     * @var date $expires_at
     */
    private $expires_at;

    /**
     * @orm:Column(type="datetime")
     *
     * @var date $created_at
     */
    private $created_at;

    /**
     * @orm:Column(type="datetime")
     *
     * @var date $updated_at
     */
    private $updated_at;

    /**
     * @orm:OneToOne(targetEntity="Profile", fetch="EAGER", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\Profile
     */
    private $profile;

    /**
     * @orm:ManyToOne(targetEntity="Language")
     *
     * @var Club\UserBundle\Entity\Language
     */
    private $language;

    /**
     * @orm:ManyToMany(targetEntity="Role", mappedBy="users", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\Role
     */
    private $roles;

    /**
     * @orm:OneToMany(targetEntity="Club\ShopBundle\Entity\Subscription", mappedBy="user")
     */
    private $subscriptions;

    /**
     * @orm:OneToMany(targetEntity="Club\ShopBundle\Entity\TicketCoupon", mappedBy="user")
     */
    private $ticket_coupons;

    public function __construct()
    {
      $this->subscriptions = new \Doctrine\Common\Collections\ArrayCollection();
      $this->roles = new \Doctrine\Common\Collections\ArrayCollection();

      $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
      $this->algorithm = 'sha512';
      $this->enabled = false;
      $this->locked = false;
      $this->expired = false;
      $this->roles = array();
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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
      $encoder = new MessageDigestPasswordEncoder($this->getAlgorithm(),true,10);
      $password = $encoder->encodePassword($password,$this->getSalt());

      $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set last_login_time
     *
     * @param date $lastLoginTime
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->last_login_time = $lastLoginTime;
    }

    /**
     * Get last_login_time
     *
     * @return date $lastLoginTime
     */
    public function getLastLoginTime()
    {
        return $this->last_login_time;
    }

    /**
     * Set last_login_ip
     *
     * @param string $lastLoginIp
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->last_login_ip = $lastLoginIp;
    }

    /**
     * Get last_login_ip
     *
     * @return string $lastLoginIp
     */
    public function getLastLoginIp()
    {
        return $this->last_login_ip;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set algorithm
     *
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Get algorithm
     *
     * @return string $algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean $locked
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * Get expired
     *
     * @return boolean $expired
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set expires_at
     *
     * @param date $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expires_at = $expiresAt;
    }

    /**
     * Get expires_at
     *
     * @return date $expiresAt
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * Set created_at
     *
     * @param date $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param date $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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

    /**
     * Set language
     *
     * @param Club\UserBundle\Entity\Language $language
     */
    public function setLanguage(\Club\UserBundle\Entity\Language $language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return Club\UserBundle\Entity\Language $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function getSubscriptions()
    {
      return $this->subscriptions;
    }

    public function getTicketCoupons()
    {
      return $this->ticket_coupons;
    }

    /**
     * @orm:prePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @orm:preUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'username' => $this->getUsername(),
        'created_at' => $this->getCreatedAt(),
        'updated_at' => $this->getUpdatedAt(),
        'profile' => array(
          'first_name' => $this->getProfile()->getFirstName(),
          'last_name' => $this->getProfile()->getLastName(),
          'gender' => $this->getProfile()->getGender()
        )
      );
    }

    public function addRole($Role)
    {
      $this->roles[] = $Role;
    }

    public function getUserRoles()
    {
      return $this->roles;
    }

    public function getRoles()
    {
      return $this->roles->toArray();
    }

    public function eraseCredentials()
    {
    }

    public function equals(UserInterface $user)
    {
      return md5($this->getUsername()) == md5($user->getUsername());
    }
}

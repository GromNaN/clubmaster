<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\LoginAttemptRepository")
 * @ORM\Table(name="club_user_login_attempt")
 * @ORM\HasLifecycleCallbacks()
 */
class LoginAttempt
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $username
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $session
     */
    protected $session;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $ip_address
     */
    protected $ip_address;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $hostname
     */
    protected $hostname;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $login_failed
     */
    protected $login_failed;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

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
     * Set session
     *
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Get session
     *
     * @return string $session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set ip_address
     *
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = $ipAddress;
    }

    /**
     * Get ip_address
     *
     * @return string $ipAddress
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Get hostname
     *
     * @return string $hostname
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set login_failed
     *
     * @param boolean $loginFailed
     */
    public function setLoginFailed($loginFailed)
    {
        $this->login_failed = $loginFailed;
    }

    /**
     * Get login_failed
     *
     * @return boolean $loginFailed
     */
    public function getLoginFailed()
    {
        return $this->login_failed;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}

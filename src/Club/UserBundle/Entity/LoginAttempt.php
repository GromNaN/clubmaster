<?php

namespace Club\UserBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\LoginAttempt")
 * @orm:Table(name="club_login_attempt")
 */
class LoginAttempt
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
     * @var string $username
     */
    private $username;

    /**
     * @orm:Column(type="string")
     *
     * @var string $session
     */
    private $session;

    /**
     * @orm:Column(type="string")
     *
     * @var string $ip_address
     */
    private $ip_address;

    /**
     * @orm:Column(type="string")
     *
     * @var string $hostname
     */
    private $hostname;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $login_failed
     */
    private $login_failed;

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
}

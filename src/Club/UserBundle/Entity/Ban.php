<?php

namespace Club\UserBundle\Entity;

use DateTime;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\Ban")
 * @orm:Table(name="club_ban")
 */
class Ban
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneradValue(strategy="AUTH")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
     * @var string $type
     */
    private $type;

    /**
     * @orm:Column(type="string")
     *
     * @var string $value
     */
    private $value;

    /**
     * @orm:Column(type="datetime")
     *
     * @var date $expire_date
     */
    private $expire_date;

    /**
     * @orm:Column(type="text")
     *
     * @var string $note
     */
    private $note;

    /**
     * @orm:ManyToOne(targetEntity="User")
     * @var Club\UserBundle\Entity\User
     */
    private $user;


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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set expire_date
     *
     * @param date $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return date $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * Set note
     *
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @orm:prePersist
     */
    public function prePersist()
    {
      $this->setExpireDate(new DateTime(date('Y-m-d H:i:s',strtotime("+1 month"))));
    }
}

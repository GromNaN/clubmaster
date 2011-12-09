<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\SubscriptionPauseRepository")
 * @ORM\Table(name="club_shop_subscription_pause")
 */
class SubscriptionPause
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
     * @ORM\Column(type="datetime")
     *
     * @var datetime $old_expire_date
     */
    protected $old_expire_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $start_date
     */
    protected $start_date;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var datetime $expire_date
     */
    protected $expire_date;

    /**
     * @ORM\ManyToOne(targetEntity="Subscription")
     *
     * @var Club\ShopBundle\Entity\Subscription
     */
    protected $subscription;


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
     * Set start_date
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return datetime $startDate
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set expire_date
     *
     * @param datetime $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return datetime $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * Set subscription
     *
     * @param Club\ShopBundle\Entity\Subscription $subscription
     */
    public function setSubscription(\Club\ShopBundle\Entity\Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get subscription
     *
     * @return Club\ShopBundle\Entity\Subscription $subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set old_expire_date
     *
     * @param date $oldExpireDate
     */
    public function setOldExpireDate($oldExpireDate)
    {
        $this->old_expire_date = $oldExpireDate;
    }

    /**
     * Get old_expire_date
     *
     * @return date
     */
    public function getOldExpireDate()
    {
        return $this->old_expire_date;
    }
}

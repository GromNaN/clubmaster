<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\BookingBundle\Entity\PlanRepeat
 *
 * @ORM\Table(name="club_booking_plan_repeat")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\PlanRepeatRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PlanRepeat
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $repeats
     *
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"hourly", "daily", "weekly", "monthly", "yearly"})
     */
    protected $repeats;

    /**
     * @var string $repeat_on
     *
     * @ORM\Column(type="string")
     */
    protected $repeat_on;

    /**
     * @var string $repeat_by
     *
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"day_of_the_month", "day_of_the_week"})
     */
    protected $repeat_by;

    /**
     * @var integer $repeat_every
     *
     * @ORM\Column(type="integer")
     */
    protected $repeat_every;

    /**
     * @var datetime $starts_on
     *
     * @ORM\Column(type="date")
     */
    protected $starts_on;

    /**
     * @var string $ends_type
     *
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"never", "after", "on"})
     */
    protected $ends_type;

    /**
     * @var integer $ends_after
     *
     * @ORM\Column(type="integer")
     */
    protected $ends_after;

    /**
     * @var datetime $ends_on
     *
     * @ORM\Column(type="date")
     */
    protected $ends_on;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    protected $plan;


    public function __construct()
    {
        $this->repeats = 'monthly';
        $this->starts_on = new \DateTime();
        $this->ends_after = '30';
        $this->ends_type = 'never';

        $end = new \DateTime();
        $i = new \DateInterval('P1Y');
        $end->add($i);
        $this->ends_on = $end;
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
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set repeats
     *
     * @param string $repeats
     * @return PlanRepeat
     */
    public function setRepeats($repeats)
    {
        $this->repeats = $repeats;

        return $this;
    }

    /**
     * Get repeats
     *
     * @return string
     */
    public function getRepeats()
    {
        return $this->repeats;
    }

    /**
     * Set repeat_on
     *
     * @param string $repeatOn
     * @return PlanRepeat
     */
    public function setRepeatOn($repeatOn)
    {
        $this->repeat_on = $repeatOn;

        return $this;
    }

    /**
     * Get repeat_on
     *
     * @return string
     */
    public function getRepeatOn()
    {
        return $this->repeat_on;
    }

    /**
     * Set repeat_by
     *
     * @param string $repeatBy
     * @return PlanRepeat
     */
    public function setRepeatBy($repeatBy)
    {
        $this->repeat_by = $repeatBy;

        return $this;
    }

    /**
     * Get repeat_by
     *
     * @return string
     */
    public function getRepeatBy()
    {
        return $this->repeat_by;
    }

    /**
     * Set starts_on
     *
     * @param \DateTime $startsOn
     * @return PlanRepeat
     */
    public function setStartsOn($startsOn)
    {
        $this->starts_on = $startsOn;

        return $this;
    }

    /**
     * Get starts_on
     *
     * @return \DateTime
     */
    public function getStartsOn()
    {
        return $this->starts_on;
    }

    /**
     * Set ends_after
     *
     * @param integer $endsAfter
     * @return PlanRepeat
     */
    public function setEndsAfter($endsAfter)
    {
        $this->ends_after = $endsAfter;

        return $this;
    }

    /**
     * Get ends_after
     *
     * @return integer
     */
    public function getEndsAfter()
    {
        return $this->ends_after;
    }

    /**
     * Set ends_on
     *
     * @param \DateTime $endsOn
     * @return PlanRepeat
     */
    public function setEndsOn($endsOn)
    {
        $this->ends_on = $endsOn;

        return $this;
    }

    /**
     * Get ends_on
     *
     * @return \DateTime
     */
    public function getEndsOn()
    {
        return $this->ends_on;
    }

    /**
     * Set plan
     *
     * @param Club\BookingBundle\Entity\Plan $plan
     * @return PlanRepeat
     */
    public function setPlan(\Club\BookingBundle\Entity\Plan $plan = null)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return Club\BookingBundle\Entity\Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set repeat_every
     *
     * @param integer $repeatEvery
     * @return PlanRepeat
     */
    public function setRepeatEvery($repeatEvery)
    {
        $this->repeat_every = $repeatEvery;

        return $this;
    }

    /**
     * Get repeat_every
     *
     * @return integer
     */
    public function getRepeatEvery()
    {
        return $this->repeat_every;
    }

    /**
     * Set ends_type
     *
     * @param string $endsType
     * @return PlanRepeat
     */
    public function setEndsType($endsType)
    {
        $this->ends_type = $endsType;

        return $this;
    }

    /**
     * Get ends_type
     *
     * @return string
     */
    public function getEndsType()
    {
        return $this->ends_type;
    }
}

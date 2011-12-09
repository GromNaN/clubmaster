<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\CurrencyRepository")
 * @ORM\Table(name="club_user_currency")
 * @ORM\HasLifecycleCallbacks()
 */
class Currency
{
    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string $currency_name
     */
    protected $currency_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string $code
     */
    protected $code;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $symbol_left
     */
    protected $symbol_left;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $symbol_right
     */
    protected $symbol_right;

    /**
     * @ORM\Column(type="string")
     * @var string $decimal_places
     */
    protected $decimal_places;

    /**
     * @ORM\Column(type="decimal", scale="5")
     * @Assert\NotBlank()
     *
     * @var float $value
     */
    protected $value;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    public function __toString()
    {
      return $this->getCurrencyName();
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
     * Set currency_name
     *
     * @param string $currency_name
     */
    public function setCurrencyName($currencyName)
    {
        $this->currency_name = $currencyName;
    }

    /**
     * Get currencyName
     *
     * @return string $currency_name
     */
    public function getCurrencyName()
    {
        return $this->currency_name;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set symbol_left
     *
     * @param string $symbolLeft
     */
    public function setSymbolLeft($symbolLeft)
    {
        $this->symbol_left = $symbolLeft;
    }

    /**
     * Get symbol_left
     *
     * @return string $symbolLeft
     */
    public function getSymbolLeft()
    {
        return $this->symbol_left;
    }

    /**
     * Set symbol_right
     *
     * @param string $symbolRight
     */
    public function setSymbolRight($symbolRight)
    {
        $this->symbol_right = $symbolRight;
    }

    /**
     * Get symbol_right
     *
     * @return string $symbolRight
     */
    public function getSymbolRight()
    {
        return $this->symbol_right;
    }

    /**
     * Set decimal_places
     *
     * @param string $decimalPlaces
     */
    public function setDecimalPlaces($decimalPlaces)
    {
        $this->decimal_places = $decimalPlaces;
    }

    /**
     * Get decimal_places
     *
     * @return string $decimalPlaces
     */
    public function getDecimalPlaces()
    {
        return $this->decimal_places;
    }

    /**
     * Set value
     *
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return float $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setActive(1);
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
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
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}

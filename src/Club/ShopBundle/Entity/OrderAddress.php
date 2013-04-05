<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\OrderAddressRepository")
 * @ORM\Table(name="club_shop_order_address")
 */
class OrderAddress
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
     * @var string $company_name
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $company_name;

    /**
     * @var string $vat
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $vat;

    /**
     * @var string $first_name
     *
     * @ORM\Column(type="string")
     */
    protected $first_name;

    /**
     * @var string $last_name
     *
     * @ORM\Column(type="string")
     */
    protected $last_name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     *
     * @var string $street
     */
    protected $street;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $postal_code
     */
    protected $postal_code;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $city
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $state
     */
    protected $state;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $country
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="Order")
     *
     * @var Club\ShopBundle\Entity\Order
     */
    protected $order;

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
     * Set companyName
     *
     * @param string $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * Get companyName
     *
     * @return string $comapny_name
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set vat
     *
     * @param string $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * Get vat
     *
     * @return string $vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set firstName
     *
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * Get firstName
     *
     * @return string $first_name
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * Get lastName
     *
     * @return string $last_name
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set street
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postal_code
     *
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;
    }

    /**
     * Get postal_code
     *
     * @return string $postalCode
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
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
     * Set order
     *
     * @param Club\ShopBundle\Entity\Order $order
     */
    public function setOrder(\Club\ShopBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Club\ShopBundle\Entity\Order $order
     */
    public function getOrder()
    {
        return $this->order;
    }
}

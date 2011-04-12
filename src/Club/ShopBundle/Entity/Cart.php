<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Cart")
 * @orm:Table(name="club_shop_cart")
 */
class Cart
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
     * @orm:Column(type="integer")
     *
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @orm:Column(type="string")
     *
     * @var string $session
     */
    private $session;

    /**
     * @orm:ManyToOne(targetEntity="Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;


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
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
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
     * Set product
     *
     * @param Club\ShopBundle\Entity\Product $product
     */
    public function setProduct(\Club\ShopBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Club\ShopBundle\Entity\Product $product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

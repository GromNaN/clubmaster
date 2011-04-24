<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Product")
 * @orm:Table(name="club_shop_product")
 */
class Product
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
     * @var string $product_name
     */
    private $product_name;

    /**
     * @orm:Column(type="text")
     *
     * @var text $description
     */
    private $description;

    /**
     * @orm:Column(type="decimal")
     *
     * @var float $price
     */
    private $price;

    /**
     * @orm:Column(type="integer", nullable="true")
     *
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @orm:ManyToMany(targetEntity="Club\UserBundle\Entity\Role")
     *
     * @var Club\UserBundle\Entity\Role
     */
    private $roles;

    /**
     * @orm:ManyToMany(targetEntity="VariantGroup")
     *
     * @var VariantGroup
     */
    private $variant_groups;

    /**
     * @orm:ManyToMany(targetEntity="Category")
     * @orm:JoinTable(name="club_shop_category_product",
     *   joinColumns={@orm:JoinColumn(name="product_id", referencedColumnName="id")},
     *   inverseJoinColumns={@orm:JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     *
     * @var Club\ShopBundle\Entity\Category
     */
    private $categories;

    /**
     * @orm:ManyToOne(targetEntity="Tax")
     *
     * @var Club\ShopBundle\Entity\Tax
     */
    private $tax;

    /**
     * @orm:OneToMany(targetEntity="ProductAttribute", mappedBy="product")
     *
     * @var Club\ShopBundle\Entity\ProductAttribute
     */
    private $product_attributes;


    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product_attributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set product_name
     *
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;
    }

    /**
     * Get product_name
     *
     * @return string $productName
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
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
     * Add roles
     *
     * @param Club\UserBundle\Entity\Role $roles
     */
    public function addRoles(\Club\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    }

    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get product_attributes
     *
     * @return Doctrine\Common\Collections\Collection $product_attributes
     */
    public function getProductAttributes()
    {
        return $this->product_attributes;
    }

    /**
     * Set tax
     *
     * @param float $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * Get tax
     *
     * @return float $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

}

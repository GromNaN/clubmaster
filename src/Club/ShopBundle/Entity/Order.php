<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Order")
 * @ORM\Table(name="club_shop_order")
 * @ORM\HasLifecycleCallbacks
 */
class Order
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
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $order_memo
     */
    protected $order_memo;

    /**
     * @ORM\Column(type="text", nullable="true")
     *
     * @var string $note
     */
    protected $note;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $currency
     */
    protected $currency;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var string $currency_value
     */
    protected $currency_value;

    /**
     * @ORM\Column(type="decimal", scale="2")
     *
     * @var string $price
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", scale="2")
     *
     * @var string $vat_price
     */
    protected $vat_price;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @Assert\Notblank()
     * @Assert\NotBlank(groups={"PaymentMethod"})
     *
     * @var Club\ShopBundle\Entity\PaymentMethod
     */
    protected $payment_method;

    /**
     * @ORM\ManyToOne(targetEntity="Shipping")
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\Shipping
     */
    protected $shipping;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     *
     * @var Club\ShopBundle\Entity\OrderStatus
     */
    protected $order_status;

    /**
     * @var Club\ShopBundle\Entity\OrderStatusHistory
     *
     * @ORM\OneToMany(targetEntity="OrderStatusHistory", mappedBy="order")
     */
    protected $order_status_history;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @Assert\NotBlank()
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderAddress", cascade={"persist"})
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\OrderAddress
     */
    protected $customer_address;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderAddress", cascade={"persist"})
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\OrderAddress
     */
    protected $shipping_address;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderAddress", cascade={"persist"})
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\OrderAddress
     */
    protected $billing_address;

    /**
     * @ORM\OneToMany(targetEntity="OrderProduct", mappedBy="order", cascade={"persist"})
     *
     * @var Club\ShopBundle\Entity\OrderProduct
     */
    protected $order_products;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    public function __construct() {
      $this->order_products = new \Doctrine\Common\Collections\ArrayCollection();
      $this->order_status_history = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set order_memo
     *
     * @param string $orderMemo
     */
    public function setOrderMemo($orderMemo)
    {
        $this->order_memo = $orderMemo;
    }

    /**
     * Get order_memo
     *
     * @return string $orderMemo
     */
    public function getOrderMemo()
    {
        return $this->order_memo;
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
     * Set currency
     *
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Get currency
     *
     * @return string $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    public function setPrice($price)
    {
      $this->price = $price;
    }

    public function getPrice()
    {
      return $this->price;
    }

    public function setVatPrice($vat_price)
    {
      $this->vat_price = $vat_price;
    }

    public function getVatPrice()
    {
      return $this->vat_price;
    }

    /**
     * Set currency_value
     *
     * @param string $currencyValue
     */
    public function setCurrencyValue($currencyValue)
    {
        $this->currency_value = $currencyValue;
    }

    /**
     * Get currency_value
     *
     * @return string $currencyValue
     */
    public function getCurrencyValue()
    {
        return $this->currency_value;
    }

    /**
     * Set payment_method
     *
     * @param Club\ShopBundle\Entity\PaymentMethod $PaymentMethod
     */
    public function setPaymentMethod(\Club\ShopBundle\Entity\PaymentMethod $PaymentMethod)
    {
        $this->payment_method = $PaymentMethod;
    }

    /**
     * Get payment_method
     *
     * @return Club\ShopBundle\Entity\PaymentMethod $PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setShipping(\Club\ShopBundle\Entity\Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function setOrderStatus(\Club\ShopBundle\Entity\OrderStatus $order_status)
    {
        $this->order_status = $order_status;
    }

    public function getOrderStatus()
    {
        return $this->order_status;
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'user_id' => $this->getUser()->getId()
      );
    }

    /**
     * Add orderProduct
     *
     * @param Club\ShopBundle\Entity\OrderProduct $order_products
     */
    public function addOrderProduct(\Club\ShopBundle\Entity\OrderProduct $orderProduct)
    {
        $this->order_products[] = $orderProduct;
    }

    /**
     * Get orderProduct
     *
     * @return Doctrine\Common\Collections\Collection $order_products
     */
    public function getOrderProducts()
    {
        return $this->order_products;
    }

    public function getProducts()
    {
        return $this->order_products;
    }

    /**
     * Get order_status_history
     *
     * @return Doctrine\Common\Collections\Collection $order_status_history
     */
    public function getOrderStatusHistory()
    {
        return $this->order_status_history;
    }

    public function setCreatedAt($createdAt)
    {
      $this->created_at = $createdAt;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    public function setCustomerAddress($customer_address)
    {
      $this->customer_address = $customer_address;
    }

    public function getCustomerAddress()
    {
      return $this->customer_address;
    }

    public function setShippingAddress($shipping_address)
    {
      $this->shipping_address = $shipping_address;
    }

    public function getShippingAddress()
    {
      return $this->shipping_address;
    }

    public function setBillingAddress($billing_address)
    {
      $this->billing_address = $billing_address;
    }

    public function getBillingAddress()
    {
      return $this->billing_address;
    }
}

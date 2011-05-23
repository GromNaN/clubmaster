<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\OrderStatusHistory")
 * @ORM\Table(name="club_shop_order_status_history")
 */
class OrderStatusHistory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var text $note
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     *
     * @var Club\ShopBundle\Entity\OrderStatus
     */
    private $order_status;

    /**
     * @ORM\ManyToOne(targetEntity="Order")
     *
     * @var Club\ShopBundle\Entity\Order
     */
    private $order;

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
     * Set note
     *
     * @param text $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return text $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set order_status
     *
     * @param Club\ShopBundle\Entity\OrderStatus $shopOrderStatus
     */
    public function setOrderStatus(\Club\ShopBundle\Entity\OrderStatus $shopOrderStatus)
    {
        $this->order_status = $shopOrderStatus;
    }

    /**
     * Get order_status
     *
     * @return Club\ShopBundle\Entity\OrderStatus $shopOrderStatus
     */
    public function getOrderStatus()
    {
        return $this->order_status;
    }
}

<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\FilterAttribute")
 * @ORM\Table(name="club_user_filter_attribute")
 */
class FilterAttribute
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
     * @ORM\Column(type="string", nullable="true")
     * @Assert\NotBlank()
     *
     * @var string $value
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     */
    private $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="Filter")
     * @ORM\JoinColumn(name="filter_id", referencedColumnName="id", onDelete="cascade")
     */
    private $filter;

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
     * Set attribute
     *
     * @param Club\UserBundle\Entity\Attribute $attribute
     */
    public function setAttribute(\Club\UserBundle\Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return Club\UserBundle\Entity\Attribute $attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set filter
     *
     * @param Club\UserBundle\Entity\Filter $filter
     */
    public function setFilter(\Club\UserBundle\Entity\Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get filter
     *
     * @return Club\UserBundle\Entity\Filter $filter
     */
    public function getFilter()
    {
        return $this->filter;
    }
}

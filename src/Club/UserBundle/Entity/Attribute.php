<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\FilterAttribute")
 * @ORM\Table(name="club_user_attribute")
 */
class Attribute
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
     * @Assert\NotBlank()
     *
     * @var string $attribute_name
     */
    private $attribute_name;

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
     * Set attribute_name
     *
     * @param string $attributeName
     */
    public function setAttributeName($attributeName)
    {
        $this->attribute_name = $attributeName;
    }

    /**
     * Get attribute_name
     *
     * @return string $attributeName
     */
    public function getAttributeName()
    {
        return $this->attribute_name;
    }
}
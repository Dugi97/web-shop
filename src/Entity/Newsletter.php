<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 */
class Newsletter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $coupon;

    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * @var boolean
     * @ORM\Column(name="isCouponUsed", type="boolean")
     */
    private $isCouponUsed = false;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function isCouponUsed(): bool
    {
        return $this->isCouponUsed;
    }

    /**
     * @param bool $isCouponUsed
     */
    public function setIsCouponUsed(bool $isCouponUsed): void
    {
        $this->isCouponUsed = $isCouponUsed;
    }

    /**
     * @return mixed
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * @param mixed $coupon
     */
    public function setCoupon($coupon): void
    {
        $this->coupon = $coupon;
    }

}

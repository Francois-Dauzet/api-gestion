<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TUsersInfoAddress
 *
 * @ORM\Table(name="t_users_info_address")
 * @ORM\Entity
 */
class TUsersInfoAddress
{
    /**
     * @var int
     *
     * @ORM\Column(name="street_number", type="integer", nullable=true)
     * 
     * @Assert\GreaterThan(0)
     */
    private ?int $streetNumber = null;

    /**
     * @var string
     *
     * @ORM\Column(name="street_name", type="string", length=500, nullable=false)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 500,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $streetName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=5, nullable=false)
     * 
     * @Assert\Regex(
     * pattern="/^(?!0{2})\d{5}$/",
     * message="Code postal non valide"
     * )
     */
    private string $postalCode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=60, nullable=false)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private $town;

    /**
     * @var \TUserAccount
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TUserAccount", mappedBy="TUserAccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_address_account", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $userIdAddressAccount;

    public function __construct()
    {
        return $this->userIdAddressAccount;
    }


    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getUserIdAddressAccount(): ?TUserAccount
    {
        return $this->userIdAddressAccount;
    }

    public function setUserIdAddressAccount(?TUserAccount $userIdAddressAccount): self
    {
        $this->userIdAddressAccount = $userIdAddressAccount;

        return $this;
    }
}

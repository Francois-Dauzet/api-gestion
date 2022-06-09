<?php

namespace App\Entity;

use App\Entity\TUserAccount;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TUserInfoPhone
 *
 * @ORM\Table(name="t_user_info_phone")
 * @ORM\Entity
 */
class TUserInfoPhone
{
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=10, nullable=false)
     * 
     * @Assert\Regex(
     * pattern="/[\+[0]]?[\+[1-7]]?[(]?[0-9]{8}[)]?[-\s\.]?$/", 
     * message="Numéro de téléphone non valide"
     * )
     */
    private string $phone = '';

    /**
     * @var \TUserAccount
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TUserAccount", mappedBy="TUserAccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_phone_account", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $userIdPhoneAccount;

    public function __construct()
    {
        return $this->userIdPhoneAccount;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getUserIdPhoneAccount(): ?TUserAccount
    {
        return $this->userIdPhoneAccount;
    }

    public function setUserIdPhoneAccount(?TUserAccount $userIdPhoneAccount): self
    {
        $this->userIdPhoneAccount = $userIdPhoneAccount;

        return $this;
    }
}

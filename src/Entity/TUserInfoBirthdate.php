<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TUserInfoBirthdate
 *
 * @ORM\Table(name="t_user_info_birthdate")
 * @ORM\Entity
 * 
 */
class TUserInfoBirthdate
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=false)
     * 
     * @Assert\Type("\DateTime")
     * 
     */
    private ?\DateTime $birthdate;

    /**
     * @var \TUserAccount
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TUserAccount", mappedBy="TUserAccount", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_birthdate_account", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $userIdBirthdateAccount;

    public function __construct()
    {
        return $this->userIdBirthdateAccount;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getUserIdBirthdateAccount(): ?TUserAccount
    {
        return $this->userIdBirthdateAccount;
    }

    public function setUserIdBirthdateAccount(?TUserAccount $userIdBirthdateAccount): self
    {
        $this->userIdBirthdateAccount = $userIdBirthdateAccount;

        return $this;
    }
}

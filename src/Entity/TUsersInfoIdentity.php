<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TUsersInfoIdentity
 *
 * @ORM\Table(name="t_users_info_identity")
 * @ORM\Entity
 */
class TUsersInfoIdentity
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45, nullable=false)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     * 
     */
    private string $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=false)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     * 
     */
    private string $lastName = '';

    /**
     * @var \TUserAccount
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TUserAccount", mappedBy="TUserAccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_identity_account", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $userIdIdentityAccount;

    public function __construct()
    {
        return $this->userIdIdentityAccount;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUserIdIdentityAccount(): ?TUserAccount
    {
        return $this->userIdIdentityAccount;
    }

    public function setUserIdIdentityAccount(?TUserAccount $userIdIdentityAccount): self
    {
        $this->userIdIdentityAccount = $userIdIdentityAccount;

        return $this;
    }
}

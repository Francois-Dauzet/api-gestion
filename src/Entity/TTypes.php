<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TTypes
 *
 * @ORM\Table(name="t_types")
 * @ORM\Entity
 */
class TTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Assert\GreaterThan(0)
     */
    private ?int $id = null;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $label = '';

    /**
     * @var \TUserAccount
     *
     * @ORM\ManyToOne(targetEntity="TUserAccount", inversedBy="TUserAccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        return $this->fkUser;
    }

    public function __toString()
    {
        return strval($this->label);
    }

    public function getFkUser(): ?TUserAccount
    {
        return $this->fkUser;
    }

    public function setFkUser(?TUserAccount $fkUser): self
    {
        $this->fkUser = $fkUser;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\TSwarms;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TDiseases
 *
 * @ORM\Table(name="t_diseases", uniqueConstraints={@ORM\UniqueConstraint(name="label_UNIQUE", columns={"label"})})
 * @ORM\Entity
 */
class TDiseases
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TSwarms", mappedBy="fkIdDiseases")
     */
    private $idSwarms;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idSwarms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->label);
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

    /**
     * @return Collection<int, TSwarms>
     */
    public function getIdSwarms(): Collection
    {
        return $this->idSwarms;
    }

    public function addIdSwarm(TSwarms $idSwarm): self
    {
        if (!$this->idSwarms->contains($idSwarm)) {
            $this->idSwarms[] = $idSwarm;
            $idSwarm->addFkIdDisease($this);
        }

        return $this;
    }

    public function removeIdSwarm(TSwarms $idSwarm): self
    {
        if ($this->idSwarms->removeElement($idSwarm)) {
            $idSwarm->removeFkIdDisease($this);
        }

        return $this;
    }
}

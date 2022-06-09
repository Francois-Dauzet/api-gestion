<?php

namespace App\Entity;

use App\Entity\THives;
use App\Entity\TNotes;
use App\Entity\TDiseases;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TSwarms
 *
 * @ORM\Table(name="t_swarms", indexes={@ORM\Index(name="fk_population_idx", columns={"fk_population"}), @ORM\Index(name="fk_temperament_idx", columns={"fk_temperament"})})
 * @ORM\Entity
 */
class TSwarms
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
     * @var \TPopulations
     *
     * @ORM\ManyToOne(targetEntity="TPopulations", inversedBy="TPopulations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_population", referencedColumnName="id")
     * })
     */
    private $fkPopulation;

    /**
     * @var \TTemperaments
     *
     * @ORM\ManyToOne(targetEntity="TTemperaments", inversedBy="TTemperaments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_temperament", referencedColumnName="id")
     * })
     */
    private $fkTemperament;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="THives", inversedBy="idSwarms")
     * @ORM\JoinTable(name="t_hive_swarms",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_swarms", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_id_hives", referencedColumnName="id")
     *   }
     * )
     */
    private $fkIdHives;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TDiseases", inversedBy="idSwarms")
     * @ORM\JoinTable(name="t_swarms_diseases",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_swarms", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_id_diseases", referencedColumnName="id")
     *   }
     * )
     */
    private $fkIdDiseases;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TNotes", mappedBy="fkIdSwarms")
     */
    private $idNotes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkIdHives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkIdDiseases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idNotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkPopulation(): ?TPopulations
    {
        return $this->fkPopulation;
    }

    public function setFkPopulation(?TPopulations $fkPopulation): self
    {
        $this->fkPopulation = $fkPopulation;

        return $this;
    }

    public function getFkTemperament(): ?TTemperaments
    {
        return $this->fkTemperament;
    }

    public function setFkTemperament(?TTemperaments $fkTemperament): self
    {
        $this->fkTemperament = $fkTemperament;

        return $this;
    }

    /**
     * @return Collection<int, THives>
     */
    public function getFkIdHives(): Collection
    {
        return $this->fkIdHives;
    }

    public function addFkIdHive(THives $fkIdHive): self
    {
        if (!$this->fkIdHives->contains($fkIdHive)) {
            $this->fkIdHives[] = $fkIdHive;
        }

        return $this;
    }

    public function removeFkIdHive(THives $fkIdHive): self
    {
        $this->fkIdHives->removeElement($fkIdHive);

        return $this;
    }

    /**
     * @return Collection<int, TDiseases>
     */
    public function getFkIdDiseases(): Collection
    {
        return $this->fkIdDiseases;
    }

    public function addFkIdDisease(TDiseases $fkIdDisease): self
    {
        if (!$this->fkIdDiseases->contains($fkIdDisease)) {
            $this->fkIdDiseases[] = $fkIdDisease;
        }

        return $this;
    }

    public function removeFkIdDisease(TDiseases $fkIdDisease): self
    {
        $this->fkIdDiseases->removeElement($fkIdDisease);

        return $this;
    }

    /**
     * @return Collection<int, TNotes>
     */
    public function getIdNotes(): Collection
    {
        return $this->idNotes;
    }

    public function addIdNote(TNotes $idNote): self
    {
        if (!$this->idNotes->contains($idNote)) {
            $this->idNotes[] = $idNote;
            $idNote->addFkIdSwarm($this);
        }

        return $this;
    }

    public function removeIdNote(TNotes $idNote): self
    {
        if ($this->idNotes->removeElement($idNote)) {
            $idNote->removeFkIdSwarm($this);
        }

        return $this;
    }
}

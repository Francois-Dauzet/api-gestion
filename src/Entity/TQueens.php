<?php

namespace App\Entity;

use App\Entity\THives;
use App\Entity\TNotes;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TQueens
 *
 * @ORM\Table(name="t_queens", uniqueConstraints={@ORM\UniqueConstraint(name="reference_UNIQUE", columns={"reference"})}, indexes={@ORM\Index(name="fk_breed_idx", columns={"fk_breed"})})
 * @ORM\Entity
 */
class TQueens
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
     * @ORM\Column(name="reference", type="string", length=45, nullable=false)
     * @Assert\Length(
     *      min = 1,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $reference = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fertilization_date", type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private ?\DateTime $fertilizationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="marking", type="boolean", nullable=false)
     */
    private bool $marking;

    /**
     * @var bool
     *
     * @ORM\Column(name="orphan", type="boolean", nullable=false)
     */
    private bool $orphan;

    /**
     * @var \TBreeds
     *
     * @ORM\ManyToOne(targetEntity="TBreeds", inversedBy="TBreeds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_breed", referencedColumnName="id")
     * })
     */
    private $fkBreed;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="THives", inversedBy="idQueens")
     * @ORM\JoinTable(name="t_hive_queens",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_queens", referencedColumnName="id")
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
     * @ORM\ManyToMany(targetEntity="TNotes", mappedBy="fkIdQueens")
     */
    private $idNotes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkIdHives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idNotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getFertilizationDate(): ?\DateTimeInterface
    {
        return $this->fertilizationDate;
    }

    public function setFertilizationDate(\DateTimeInterface $fertilizationDate): self
    {
        $this->fertilizationDate = $fertilizationDate;

        return $this;
    }

    public function getMarking(): ?bool
    {
        return $this->marking;
    }

    public function setMarking(bool $marking): self
    {
        $this->marking = $marking;

        return $this;
    }

    public function getOrphan(): ?bool
    {
        return $this->orphan;
    }

    public function setOrphan(bool $orphan): self
    {
        $this->orphan = $orphan;

        return $this;
    }

    public function getFkBreed(): ?TBreeds
    {
        return $this->fkBreed;
    }

    public function setFkBreed(?TBreeds $fkBreed): self
    {
        $this->fkBreed = $fkBreed;

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
            $idNote->addFkIdQueen($this);
        }

        return $this;
    }

    public function removeIdNote(TNotes $idNote): self
    {
        if ($this->idNotes->removeElement($idNote)) {
            $idNote->removeFkIdQueen($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\TNotes;
use App\Entity\TQueens;
use App\Entity\TSwarms;
use App\Entity\TCategories;
use App\Entity\TUserAccount;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * THives
 *
 * @ORM\Table(name="t_hives", indexes={@ORM\Index(name="fk_material_idx", columns={"fk_material"}), @ORM\Index(name="fk_apiary_idx", columns={"fk_apiary"}), @ORM\Index(name="fk_type_idx", columns={"fk_type"}), @ORM\Index(name="fk_format_idx", columns={"fk_format"}), @ORM\Index(name="fk_state_idx", columns={"fk_state"}), @ORM\Index(name="fk_category_idx", columns={"fk_category"})})
 * @ORM\Entity
 */
class THives
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
     * @ORM\Column(name="purchase_date", type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private ?\DateTime $purchaseDate;

    /**
     * @var string
     *
     * @ORM\Column(name="note_text", type="text", length=65535, nullable=true)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 65535,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $noteText;

    /**
     * @var \TMateriels
     *
     * @ORM\ManyToOne(targetEntity="TMateriels", inversedBy="TMateriels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_material", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkMaterial;

    /**
     * @var \TTypes
     *
     * @ORM\ManyToOne(targetEntity="TTypes", inversedBy="TTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_type", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkType;

    /**
     * @var \TApiaries
     *
     * @ORM\ManyToOne(targetEntity="TApiaries", inversedBy="TApiaries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_apiary", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkApiary;

    /**
     * @var \TFormats
     *
     * @ORM\ManyToOne(targetEntity="TFormats", inversedBy="TFormats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_format", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkFormat;

    /**
     * @var \TStates
     *
     * @ORM\ManyToOne(targetEntity="TStates", inversedBy="TStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_state", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkState;

    /**
     * @var \TCategories
     *
     * @ORM\ManyToOne(targetEntity="TCategories", inversedBy="TCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_category", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkCategory;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="TQueens", mappedBy="fkIdHives")
     */
    private $idQueens;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="TSwarms", mappedBy="fkIdHives")
     */
    private $idSwarms;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="TNotes", mappedBy="fkIdHives")
     */
    private $idNotes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idQueens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idSwarms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idNotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->reference);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getNoteText(): string
    {
        return $this->noteText;
    }

    public function setNoteText(string $noteText): self
    {
        $this->noteText = $noteText;

        return $this;
    }

    public function getFkMaterial(): ?TMateriels
    {
        return $this->fkMaterial;
    }

    public function setFkMaterial(?TMateriels $fkMaterial): self
    {
        $this->fkMaterial = $fkMaterial;

        return $this;
    }

    public function getFkType(): ?TTypes
    {
        return $this->fkType;
    }

    public function setFkType(?TTypes $fkType): self
    {
        $this->fkType = $fkType;

        return $this;
    }

    public function getFkApiary(): ?TApiaries
    {
        return $this->fkApiary;
    }

    public function setFkApiary(?TApiaries $fkApiary): self
    {
        $this->fkApiary = $fkApiary;

        return $this;
    }

    public function getFkFormat(): ?TFormats
    {
        return $this->fkFormat;
    }

    public function setFkFormat(?TFormats $fkFormat): self
    {
        $this->fkFormat = $fkFormat;

        return $this;
    }

    public function getFkState(): ?TStates
    {
        return $this->fkState;
    }

    public function setFkState(?TStates $fkState): self
    {
        $this->fkState = $fkState;

        return $this;
    }

    public function getFkCategory(): ?TCategories
    {
        return $this->fkCategory;
    }

    public function setFkCategory(?TCategories $fkCategory): self
    {
        $this->fkCategory = $fkCategory;

        return $this;
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

    /**
     * @return Collection<int, TQueens>
     */
    public function getIdQueens(): Collection
    {
        return $this->idQueens;
    }

    public function addIdQueen(TQueens $idQueen): self
    {
        if (!$this->idQueens->contains($idQueen)) {
            $this->idQueens[] = $idQueen;
            $idQueen->addFkIdHive($this);
        }

        return $this;
    }

    public function removeIdQueen(TQueens $idQueen): self
    {
        if ($this->idQueens->removeElement($idQueen)) {
            $idQueen->removeFkIdHive($this);
        }

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
            $idSwarm->addFkIdHive($this);
        }

        return $this;
    }

    public function removeIdSwarm(TSwarms $idSwarm): self
    {
        if ($this->idSwarms->removeElement($idSwarm)) {
            $idSwarm->removeFkIdHive($this);
        }

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
            $idNote->addFkIdHive($this);
        }

        return $this;
    }

    public function removeIdNote(TNotes $idNote): self
    {
        if ($this->idNotes->removeElement($idNote)) {
            $idNote->removeFkIdHive($this);
        }

        return $this;
    }
}

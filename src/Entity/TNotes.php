<?php

namespace App\Entity;

use App\Entity\THives;
use App\Entity\TQueens;
use App\Entity\TSwarms;
use App\Entity\TApiaries;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TNotes
 *
 * @ORM\Table(name="t_notes")
 * @ORM\Entity
 */
class TNotes
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private ?\DateTime $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="note_text", type="text", length=65535, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 65535,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $noteText = '';

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", length=45, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $authorName = '';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TApiaries", inversedBy="idNotes")
     * @ORM\JoinTable(name="t_apiaries_notes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_notes", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_id_apiaries", referencedColumnName="id")
     *   }
     * )
     */
    private ?int $fkIdApiaries = null;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="THives", inversedBy="idNotes")
     * @ORM\JoinTable(name="t_hives_notes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_notes", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_id_hives", referencedColumnName="id")
     *   }
     * )
     */
    private ?int $fkIdHives = null;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TQueens", inversedBy="idNotes")
     * @ORM\JoinTable(name="t_queens_notes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_notes", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_id_queens", referencedColumnName="id")
     *   }
     * )
     */
    private ?int $fkIdQueens = null;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TSwarms", inversedBy="idNotes")
     * @ORM\JoinTable(name="t_swarms_notes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_notes", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_id_swarms", referencedColumnName="id")
     *   }
     * )
     */
    private ?int $fkIdSwarms = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkIdApiaries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkIdHives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkIdQueens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkIdSwarms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

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

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @return Collection<int, TApiaries>
     */
    public function getFkIdApiaries(): Collection
    {
        return $this->fkIdApiaries;
    }

    public function addFkIdApiary(TApiaries $fkIdApiary): self
    {
        if (!$this->fkIdApiaries->contains($fkIdApiary)) {
            $this->fkIdApiaries[] = $fkIdApiary;
        }

        return $this;
    }

    public function removeFkIdApiary(TApiaries $fkIdApiary): self
    {
        $this->fkIdApiaries->removeElement($fkIdApiary);

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
     * @return Collection<int, TQueens>
     */
    public function getFkIdQueens(): Collection
    {
        return $this->fkIdQueens;
    }

    public function addFkIdQueen(TQueens $fkIdQueen): self
    {
        if (!$this->fkIdQueens->contains($fkIdQueen)) {
            $this->fkIdQueens[] = $fkIdQueen;
        }

        return $this;
    }

    public function removeFkIdQueen(TQueens $fkIdQueen): self
    {
        $this->fkIdQueens->removeElement($fkIdQueen);

        return $this;
    }

    /**
     * @return Collection<int, TSwarms>
     */
    public function getFkIdSwarms(): Collection
    {
        return $this->fkIdSwarms;
    }

    public function addFkIdSwarm(TSwarms $fkIdSwarm): self
    {
        if (!$this->fkIdSwarms->contains($fkIdSwarm)) {
            $this->fkIdSwarms[] = $fkIdSwarm;
        }

        return $this;
    }

    public function removeFkIdSwarm(TSwarms $fkIdSwarm): self
    {
        $this->fkIdSwarms->removeElement($fkIdSwarm);

        return $this;
    }
}

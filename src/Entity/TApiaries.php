<?php

namespace App\Entity;

use App\Entity\TNotes;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * TApiaries
 *
 * @ORM\Table(name="t_apiaries", indexes={@ORM\Index(name="fk_user_idx", columns={"fk_user"}), @ORM\Index(name="fk_honeyed_idx", columns={"fk_honeyed"}), @ORM\Index(name="fk_coordinate_gps_idx", columns={"fk_coordinate_gps"})})
 * @ORM\Entity
 */
class TApiaries
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Assert\GreaterThan(0)
     */
    private ?int $id = null;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="site_name", type="string", length=60, nullable=false)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $siteName = '';

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
     * @var \TCoordinatesGps
     *
     * @ORM\ManyToOne(targetEntity="TCoordinatesGps", inversedBy="TCoordinatesGps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_coordinate_gps", referencedColumnName="id")
     * })
     */
    private $fkCoordinateGps;

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
     * @var \THoneyed
     *
     * @ORM\ManyToOne(targetEntity="THoneyed", inversedBy="THoneyed")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_honeyed", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkHoneyed;


    /**
     * Constructor
     */
    public function __construct()
    {
        return $this->fkUser;
    }

    public function __toString()
    {
        return strval($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSiteName(): string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): self
    {
        $this->siteName = $siteName;

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

    public function getFkCoordinateGps(): ?TCoordinatesGps
    {
        return $this->fkCoordinateGps;
    }

    public function setFkCoordinateGps(?TCoordinatesGps $fkCoordinateGps): self
    {
        $this->fkCoordinateGps = $fkCoordinateGps;

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

    public function getFkHoneyed(): ?THoneyed
    {
        return $this->fkHoneyed;
    }

    public function setFkHoneyed(?THoneyed $fkHoneyed): self
    {
        $this->fkHoneyed = $fkHoneyed;

        return $this;
    }
}

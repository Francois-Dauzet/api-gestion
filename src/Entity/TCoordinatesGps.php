<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TCoordinatesGps
 *
 * @ORM\Table(name="t_coordinates_gps", uniqueConstraints={@ORM\UniqueConstraint(name="latitude_UNIQUE", columns={"latitude"}), @ORM\UniqueConstraint(name="longitude_UNIQUE", columns={"longitude"})})
 * @ORM\Entity
 */
class TCoordinatesGps
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
     * @ORM\Column(name="longitude", type="string", length=45, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $longitude = '';

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=45, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "{{ limit }} caractères minimum",
     *      maxMessage = "{{ limit }} caractères maximum"
     * )
     */
    private string $latitude = '';

    public function __toString()
    {
        return strval($this->id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}

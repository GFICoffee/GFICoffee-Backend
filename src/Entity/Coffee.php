<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coffee")
 */
class Coffee
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    protected $img;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    protected $name;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    protected $desc;

    /**
     * @var integer|null
     * @ORM\Column(nullable=true, type="integer")
     */
    protected $intensity;

    /**
     * @var CoffeeType|null
     * @ORM\ManyToOne(targetEntity="App\Entity\CoffeeType")
     */
    protected $type;

    /**
     * @var integer|null
     * @ORM\Column(nullable=true, type="float")
     */
    protected $unitPrice;

    /**
     * @return int|null
     */
    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    /**
     * @param int|null $unitPrice
     */
    public function setUnitPrice(?int $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return null|string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param null|string $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDesc(): ?string
    {
        return $this->desc;
    }

    /**
     * @param null|string $desc
     */
    public function setDesc(?string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * @return int|null
     */
    public function getIntensity(): ?int
    {
        return $this->intensity;
    }

    /**
     * @param int|null $intensity
     */
    public function setIntensity(?int $intensity): void
    {
        $this->intensity = $intensity;
    }

    /**
     * @return CoffeeType|null
     */
    public function getType(): ?CoffeeType
    {
        return $this->type;
    }

    /**
     * @param CoffeeType|null $type
     */
    public function setType(?CoffeeType $type): void
    {
        $this->type = $type;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
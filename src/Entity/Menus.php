<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenusRepository::class)
 */
class Menus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $composants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_menu;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="menus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getComposants(): ?string
    {
        return $this->composants;
    }

    public function setComposants(string $composants): self
    {
        $this->composants = $composants;

        return $this;
    }

    public function getImgMenu(): ?string
    {
        return $this->img_menu;
    }

    public function setImgMenu(?string $img_menu): self
    {
        $this->img_menu = $img_menu;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRestaurant(): ?Restaurants
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurants $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }
}

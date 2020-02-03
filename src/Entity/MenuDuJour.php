<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuDuJourRepository")
 */
class MenuDuJour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_du_jour;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plat", mappedBy="menuDuJour")
     */
    private $plats;

    public function __construct()
    {
        $this->plats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDuJour(): ?\DateTimeInterface
    {
        return $this->date_du_jour;
    }

    public function setDateDuJour(\DateTimeInterface $date_du_jour): self
    {
        $this->date_du_jour = $date_du_jour;

        return $this;
    }

    /**
     * @return Collection|Plat[]
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats[] = $plat;
            $plat->setMenuDuJour($this);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        if ($this->plats->contains($plat)) {
            $this->plats->removeElement($plat);
            // set the owning side to null (unless already changed)
            if ($plat->getMenuDuJour() === $this) {
                $plat->setMenuDuJour(null);
            }
        }

        return $this;
    }

}

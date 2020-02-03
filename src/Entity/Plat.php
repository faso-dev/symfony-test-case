<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlatRepository")
 */
class Plat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LigneCommande", mappedBy="plat")
     */
    private $ligneCommandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuDuJour", inversedBy="plat")
     */
    private $menuDuJour;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type_plat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuantiteLivreur", mappedBy="plat")
     */
    private $quantiteLivreurs;
    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
        $this->quantiteLivreurs = new ArrayCollection();
    }

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|LigneCommande[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->addPlat($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->removeElement($ligneCommande);
            $ligneCommande->removePlat($this);
        }

        return $this;
    }

    public function getMenuDuJour(): ?MenuDuJour
    {
        return $this->menuDuJour;
    }

    public function setMenuDuJour(?MenuDuJour $menuDuJour): self
    {
        $this->menuDuJour = $menuDuJour;

        return $this;
    }

    public function getTypePlat(): ?string
    {
        return $this->type_plat;
    }

    public function setTypePlat(string $type_plat): self
    {
        $this->type_plat = $type_plat;

        return $this;
    }

    /**
     * @return Collection|QuantiteLivreur[]
     */
    public function getQuantiteLivreurs(): Collection
    {
        return $this->quantiteLivreurs;
    }

    public function addQuantiteLivreur(QuantiteLivreur $quantiteLivreur): self
    {
        if (!$this->quantiteLivreurs->contains($quantiteLivreur)) {
            $this->quantiteLivreurs[] = $quantiteLivreur;
            $quantiteLivreur->setPlat($this);
        }

        return $this;
    }

    public function removeQuantiteLivreur(QuantiteLivreur $quantiteLivreur): self
    {
        if ($this->quantiteLivreurs->contains($quantiteLivreur)) {
            $this->quantiteLivreurs->removeElement($quantiteLivreur);
            // set the owning side to null (unless already changed)
            if ($quantiteLivreur->getPlat() === $this) {
                $quantiteLivreur->setPlat(null);
            }
        }

        return $this;
    }

}

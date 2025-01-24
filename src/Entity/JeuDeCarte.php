<?php

namespace App\Entity;

use App\Repository\JeuDeCarteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuDeCarteRepository::class)]
class JeuDeCarte extends Jeu
{
    
    #[ORM\Column]
    private ?int $nbCarte = null;

    public function getNbCarte(): ?int
    {
        return $this->nbCarte;
    }

    public function setNbCarte(int $nbCarte): static
    {
        $this->nbCarte = $nbCarte;

        return $this;
    }
}

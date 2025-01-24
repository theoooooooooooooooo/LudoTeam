<?php

namespace App\Entity;

use App\Repository\JeuDePlateauRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuDePlateauRepository::class)]
class JeuDePlateau extends Jeu
{

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ressource = null;


    public function getRessource(): ?string
    {
        return $this->ressource;
    }

    public function setRessource(string $ressource): static
    {
        $this->ressource = $ressource;

        return $this;
    }
}

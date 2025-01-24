<?php

namespace App\Entity;

use App\Repository\JeuDeDuelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuDeDuelRepository::class)]
class JeuDeDuel extends Jeu
{

}

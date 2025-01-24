<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Form\JeuType;
use App\Entity\JeuDeDuel;
use App\Entity\JeuDeCarte;
use App\Form\JeuDeDuelType;
use App\Entity\JeuDePlateau;
use App\Form\JeuDeCarteType;
use App\Form\JeuDePlateauType;
use App\Repository\JeuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/jeu')]
final class JeuController extends AbstractController
{
    #[Route(name: 'app_jeu_index', methods: ['GET'])]
    public function index(JeuRepository $jeuRepository): Response
    {
        $jeux = $jeuRepository->findAll();

        $jeuxWithType = [];
        foreach ($jeux as $jeu) {
            $jeuxWithType[] = [
                'jeu' => $jeu,
                'type' => $jeu instanceof \App\Entity\JeuDeCarte ? 'JeuDeCarte' :
                         ($jeu instanceof \App\Entity\JeuDePlateau ? 'JeuDePlateau' : 
                         ($jeu instanceof \App\Entity\JeuDeDuel ? 'JeuDeDuel' : 'Inconnu'))
            ];
        }
        return $this->render('jeu/index.html.twig', [
            'jeux' => $jeuxWithType,
        ]);
    }

    #[Route('/new', name: 'app_jeu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $type = $request->query->get('type');
    
        if (!$type) {
            return $this->render('jeu/select_type.html.twig', [
                'types' => [
                    'Jeu de Carte' => 'jeuDeCarte',
                    'Jeu de Plateau' => 'jeuDePlateau',
                    'Jeu de Duel' => 'jeuDeDuel',
                ],
            ]);
        }
    
        switch ($type) {
            case 'jeuDeCarte':
                $jeu = new JeuDeCarte();
                $formType = JeuDeCarteType::class;
                break;
            case 'jeuDePlateau':
                $jeu = new JeuDePlateau();
                $formType = JeuDePlateauType::class;
                break;
            case 'jeuDeDuel':
                $jeu = new JeuDeDuel();
                $formType = JeuDeDuelType::class;
                break;
            default:
                throw $this->createNotFoundException('Type de jeu inconnu.');
        }
    
        $form = $this->createForm($formType, $jeu);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jeu);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('jeu/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    


    #[Route('/{id}', name: 'app_jeu_show', methods: ['GET'])]
    public function show(Jeu $jeu): Response
    {
        return $this->render('jeu/show.html.twig', [
            'jeu' => $jeu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_jeu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        if ($jeu instanceof \App\Entity\JeuDeCarte) {
            $formType = \App\Form\JeuDeCarteType::class;
        } elseif ($jeu instanceof \App\Entity\JeuDePlateau) {
            $formType = \App\Form\JeuDePlateauType::class;
        } elseif ($jeu instanceof \App\Entity\JeuDeDuel) {
            $formType = \App\Form\JeuDeDuelType::class;
        } else {
            throw $this->createNotFoundException('Type de jeu non pris en charge.');
        }
        $form = $this->createForm($formType, $jeu);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('jeu/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{id}', name: 'app_jeu_delete', methods: ['POST'])]
    public function delete(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jeu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($jeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
    }
}

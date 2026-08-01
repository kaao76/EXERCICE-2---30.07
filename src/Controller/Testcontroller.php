<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController
{
    #[Route('/ajouter-utilisateur')]
    public function ajouter(EntityManagerInterface $em): Response
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom("Martin");
        $utilisateur->setPrenom("Julie");
        $utilisateur->setAneeNaissance(1995);
        $utilisateur->setEmail("julie.martin@example.com");

        try {
            $em->persist($utilisateur);
            $em->flush();
            echo "Utilisateur ajouté ! Âge : " . $utilisateur->getAge() . " ans.";
        } catch (\Exception $e) {
            echo "Erreur : cet email existe déjà (doit être unique).";
        }

        return new Response();
    }
}
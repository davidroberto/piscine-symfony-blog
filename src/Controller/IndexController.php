<?php

// on créé un namespace
// c'est à dire un chemin pour identifier la classe
// actuelle
namespace App\Controller;

// on appelle le namespace des classes qu'on utilise
// pour que symfony fasse le require de ces classes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

// on étend la classe AbstractController
// qui permet d'utiliser des fonctions
// utilitaires pour les controllers (twig etc)
class IndexController extends AbstractController
{

    // annotation
    // permet de créer une route
    // c'est à dire une nouvelle page
    // sur notre appli
    // Quand l'url est appelée
    // ça execute automatiquement la méthode
    // définit sous la route
    #[Route('/', name: 'home')]
    public function index() {
        return $this->render('page/index.html.twig');
    }


}
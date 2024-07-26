<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokemonController extends AbstractController
{

    #[Route('/pokemons/{idPokemon}', name: 'show_pokemon')]
    // injection de dépendance (ou "autowire") : on demande à Symfony
    // de créer une instance de la classe Request
    // dans la variable $request
    public function showPokemon(int $idPokemon): Response
    {
        $pokemonFound = null;

        foreach ($this->pokemons as $pokemon) {
            if($pokemon['id'] === (int)$idPokemon) {
                $pokemonFound = $pokemon;
            }
        }

        return $this->render('page/pokemon_show.html.twig', [
            'pokemon' => $pokemonFound
        ]);

    }


    #[Route('/pokemons', name: 'pokemon_list_db')]
    public function listPokemonFromDb(PokemonRepository $pokemonRepository) {
        // récupèrer tous les pokemons en BDD

        $pokemons = $pokemonRepository->findAll();


        return $this->render('page/pokemon_list_db.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    #[Route('/pokemons/{id}', name: 'pokemon_by_id_db')]
    public function showPokemonById(int $id, PokemonRepository $pokemonRepository): Response
    {

        $pokemon = $pokemonRepository->find($id);

        return $this->render('page/pokemon_show_db.html.twig', [
            'pokemon' => $pokemon
        ]);


    }


    #[Route('/pokemons/search/title', name: 'pokemon_search')]
    public function searchPokemon(Request $request, PokemonRepository $pokemonRepository): Response
    {

        $pokemonsFound = [];

        if ($request->request->has('title')) {

            $titleSearched = $request->request->get('title');

            $pokemonsFound = $pokemonRepository->findLikeTitle($titleSearched);

            if (count($pokemonsFound) === 0) {
                $html = $this->renderView('page/404.html.twig');
                return new Response($html, 404);
            }

        }

        return $this->render('page/pokemon_search.html.twig', [
            'pokemons' => $pokemonsFound
        ]);
    }



    #[Route('/pokemons/delete/{id}', name: 'delete_pokemon')]
    public function deletePokemon(int $id, PokemonRepository $pokemonRepository, EntityManagerInterface $entityManager): Response
    {
       $pokemon = $pokemonRepository->find($id);

       // j'utilise la classe entity manager
        // pour préparer la requête SQL de suppression
        // cette requête n'est pas executée tout de suite
       $entityManager->remove($pokemon);
       // j'execute la / les requête SQL préparée
       $entityManager->flush();

       return $this->redirectToRoute('pokemon_list_db');
    }

}
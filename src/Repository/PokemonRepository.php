<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function findLikeTitle($search)
    {
        $queryBuilder = $this->createQueryBuilder('pokemon');

        $query = $queryBuilder
            ->select('pokemon')
            ->where('pokemon.title LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->leftJoin()
            ->getQuery();

        $pokemons = $query->getResult();

        return $pokemons;
    }



}

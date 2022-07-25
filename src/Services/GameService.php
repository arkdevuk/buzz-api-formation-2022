<?php

namespace App\Services;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function getBySlug(string $slug): ?Game
    {
        return $this->em->getRepository(Game::class)
            ->findOneBy(['slug' => $slug]);
    }

    public function getGames(
        int  $page = 1,
        int  $perPage = 10,
        bool $countMode = false,
    ): array
    {
        $repo = $this->em->getRepository(Game::class);
        if (!$countMode) {
            // DESC // ASC
            return $repo->findBy(
                [], // pas de critére parce qu'on veut tout recupérer
                ['dateRelease' => 'DESC'], // tri par date de sortie
                $perPage, ($page - 1) * $perPage // pagination
            );
        }

        $totalArticles = (int)$repo->createQueryBuilder('g')
            ->select('count(g.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $ret = [
            'total' => $totalArticles,
            'perPage' => $perPage,
            'totalPages' => ceil($totalArticles / $perPage),
        ];

        return $ret;
    }
}









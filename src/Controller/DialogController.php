<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticlePicture;
use App\Services\NewsService;
use App\Services\TrollService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DialogController extends AbstractController
{
    public function defaultAction(
        Request                $request,
        TrollService           $trollService,
        NewsService            $newsService,
        EntityManagerInterface $em,
    ): Response
    {
        $nomDuBobby = $request->get('bobby', null);


        $repo = $em->getRepository(Article::class);


        $articles = $newsService->getNews();


        return $this->render('index.html.twig', [
            'troll' => $trollService->getTroll($nomDuBobby),
            'articles' => $articles,
            'user' => [
                'name' => 'Bobby',
                'age' => '42',
            ],
        ]);
    }

    public function apiAction(
        Request                $request,
        TrollService           $trollService,
        EntityManagerInterface $em,
    ): JsonResponse
    {
        $nomDuBobby = $request->get('bobby', null);

        // do not do this PLZ
        /*
        $truc = new Article();
        $truc
            ->setTitle('Article avec un titre et une image')
            ->setContent('Truc contenu')
            ->setDescription('Truc description')
        ;

        $pp = new ArticlePicture();
        $pp
            ->setName('Truc')
            ->setUrl('https://via.placeholder.com/150')
            ;

        $truc->setImage($pp);


        //$em->persist($pp);
        //$em->persist($truc);
        //$em->flush();
        //*/


        dump($truc);
        die;

        return $this->json([
            'message' => $trollService->getTroll($nomDuBobby),
        ]);
    }
}
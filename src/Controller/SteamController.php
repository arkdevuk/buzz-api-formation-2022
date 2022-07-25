<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Media;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SteamController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('steam/index.html.twig', [
            'controller_name' => 'SteamController',
        ]);
    }

    public function product(): Response
    {
        return $this->render('page_achat.html.twig', [
            'controller_name' => 'SteamController',
        ]);
    }

    public function form(
        Request                $request,
        EntityManagerInterface $em,
    ): Response
    {
        $game
            = new Game('Nouveau jeu du '
            . date('d/m/Y'));

        $form = $this->createForm(GameType::class,
            $game);
        $form->handleRequest($request);

        //dump(sys_get_temp_dir());die;

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('attachement')->getData();
            if (is_array($files) && $files !== []) {
                foreach ($files as $file) {
                    if ($file instanceof UploadedFile) {
                        $ext = $file->guessExtension();
                        $fileName = uniqid('media_', true)
                            . '.' . $ext;
                        $file->move(
                            __DIR__ . '/../../public/assets/uploads',
                            $fileName,
                        );
                        $media = new Media();
                        $media
                            ->setSize(0)
                            ->setFormat($ext)
                            ->setName($fileName)
                            ->setUrl('/assets/uploads/' . $fileName);
                        $em->persist($media);
                        $game->addPicture($media);
                    }// end if instaceof
                }// end foreach
            }// end if is_array

            $em->persist($game);
            $em->flush();
            //dump($files, $game);die;
        }

        return $this->render('page_form_steam.html.twig', [
            'myForm' => $form->createView(),
            'controller_name' => 'SteamController',
        ]);
    }


}
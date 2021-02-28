<?php

namespace App\Controller;

use App\Entity\Music;
use App\Repository\ComposerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicController extends AbstractController
{
    /**
     * @Route("/music", name="music_index")
     */
    public function index(): Response
    {
        return $this->render('music/index.html.twig', []);
    }

    /**
     * @Route("/music/new", name="music_new")
     */
    public function new(EntityManagerInterface $em, ComposerRepository $composerRepository)
    {
        $composer = $composerRepository->findOneBy([
            'name' => 'Leonard Bernstein',
        ], [
            'id' => 'DESC',
        ]);

        $music = new Music();
        $music->setName('Prélude');
        $music->setComposer($composer);

        $em->persist($music);

        $em->flush();

        return $this->redirectToRoute('music_index');
    }
}

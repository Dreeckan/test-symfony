<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Repository\ComposerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComposerController extends AbstractController
{
    /**
     * @Route("/composer", name="composer_index")
     */
    public function index(ComposerRepository $composerRepository): Response
    {
        $composers = $composerRepository->findAll();

        return $this->render('composer/index.html.twig', [
            'composers' => $composers,
        ]);
    }

    /**
     * @Route("/composer/new", name="composer_new")
     */
    public function new(EntityManagerInterface $entityManager): Response
    {
        $composer1 = new Composer();
        $composer1->setName('Alban Berg');
        $composer1->setDescription("Alban Berg est un compositeur autrichien, né le 9 février 1885 à Vienne et mort dans la même ville le 24 décembre 1935. ");
        $composer1->setBirth(1885);
        $composer1->setDeath(1935);
        $composer1->setBirthCountry('Autriche');

        $entityManager->persist($composer1);

        $composer2 = new Composer();
        $composer2->setName('Leonard Bernstein');
        $composer2->setDescription("Leonard Bernstein est un compositeur, chef d'orchestre et pianiste américain, né à Lawrence Massachusetts le 25 août 1918 et décédé le 14 octobre 1990.");
        $composer2->setBirth(1918);
        $composer2->setDeath(1990);
        $composer2->setBirthCountry('Etats Unis');

        $entityManager->persist($composer2);
        $entityManager->flush();

        return $this->redirectToRoute('composer_index');
    }

    /**
     * @Route("/composer/test/{search}", name="composer_test")
     */
    public function test(ComposerRepository $composerRepository, string $search): Response
    {
        $results = $composerRepository->search($search);

        dd($results);

        return $this->render('composer/test.html.twig', [
            'results' => $results,
        ]);
    }

    /**
     * @Route("/composer/{id}", name="composer_show")
     */
    public function show(Composer $composer): Response
    {
        return $this->render('composer/show.html.twig', [
            'composer' => $composer,
        ]);
    }
}

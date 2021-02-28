<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(EntityManagerInterface $entityManager): RedirectResponse
    {
        $tag1 = new Tag();
        $tag1->setName('Animaux');

        $entityManager->persist($tag1);

        $tag2 = new Tag();
        $tag2->setName('Fabulous');

        $entityManager->persist($tag2);

        $article1 = new Article();
        $article1->setTitle('Un article fabuleux');
        $article1->setContent('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.');
        $article1->setTag($tag2);

        $entityManager->persist($article1);

        $article2 = new Article();
        $article2->setTitle('Un article sur les animaux mignons');
        $article2->setContent('Ils sont super mignons ! Le 99ème va vous surprendre !');
        $article2->setTag($tag1);

        $entityManager->persist($article2);

        $entityManager->flush();

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/{id}/update", name="update")
     */
    public function update(Article $article, EntityManagerInterface $entityManager)
    {
        $article->setContent('Cet article est vraiment super bien !');

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/{id}/remove", name="remove")
     */
    public function remove(Article $article, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/search/{text}", name="search")
     *
     * @param string            $text
     * @param ArticleRepository $articleRepository
     *
     * @return Response
     */
    public function search(string $text, ArticleRepository $articleRepository): Response
    {
        $results = $articleRepository->search($text);

        return $this->render('blog/search.html.twig', [
            'results' => $results,
        ]);
    }
}

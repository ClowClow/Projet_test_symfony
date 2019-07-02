<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Article;
use App\Repository\ArticleRepository;


class OfController extends AbstractController
{
    /**
    * @route("/", name="home")
    */
    public function home(ArticleRepository $repo)
    {
      $article = $repo->findAll();
      $articles = $repo->findArticle();

      return $this->render('of/home.html.twig', [
        'controller_name' => 'OfController',
        'articles' => $articles
      ]);
    }
    /**
    * @route("/of/about", name="about")
    */
    public function about()
    {
      return $this->render('of/about.html.twig', [

      ]);
    }
    /**
    * @route("/of/adopt", name="adopt")
    */
    public function adopt()
    {
      return $this->render('of/adopt.html.twig', [

      ]);
    }
    /**
     * @Route("/of/blog", name="blog")
     */
    public function blog(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('of/blog.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/of/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('of/contact.html.twig', [

        ]);
    }
    /**
    * @route("/of/portail", name="portail")
    */
    public function portail_admin()
    {
      return $this->render('of/admin/portail.html.twig');
    }

    /**
    * @route("/of/new", name="of_create")
    */
    public function create(Request $request, ObjectManager $manager)
    {
      $article = new Article();

      $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $article->setCreatedAt(new \DateTime());

        $manager->persist($article);
        $manager->flush();

        return $this ->redirectToRoute('of_publish');
      }

      return $this->render('of/admin/create.html.twig', [
        'formArticle' => $form->createView()
      ]);
    }
    /**
    * @route("/of/publish", name="of_publish")
    */
    public function publish()
    {
      return $this->render('of/admin/publish.html.twig', [
      ]);
      }
    /**
    * @route("/of/{id}", name="of_show")
    */
    public function show(ArticleRepository $repo, $id)
    {

      $article = $repo->find($id);
      return $this->render('of/show.html.twig', [
        'article' => $article
      ]);
      }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/course", name="api_liste", methods={"GET"})
     */
    public function liste(ArticleRepository $repo): Response
    {
        $liste = $repo->findAll();
        return $this->json($liste);
    }
    /**
     * @Route("/api/course", name="api_ajouter", methods={"POST"})
     */
    public function ajouter(Request $req, EntityManagerInterface $em): Response
    {
        $object = json_decode($req -> getContent());

        $article = new Article();
        $article->setName($object->name);
        $article->setIsChecked($object->isChecked);
        $em->persist($article);
        $em->flush();
        
        return $this->json($article);
    }
    /**
     * @Route("/api/course/{id}", name="api_modifier", methods={"PUT"})
     */
    public function modifier(Article $article,Request $req, EntityManagerInterface $em): Response
    {
        $object = json_decode($req -> getContent());

        
        $article->setIsChecked(!$article->getIsChecked());
        $em->flush();
        
        return $this->json($article);
    }
    /**
     * @Route("/api/course/{id}", name="api_suprimer", methods={"DELETE"})
     */
    public function suprimer(Article $article, EntityManagerInterface $em): Response
    {
        $tab = ['personne suprimer'];
        $em->remove($article);
        $em->flush();
        return $this->json($tab);
    }
}

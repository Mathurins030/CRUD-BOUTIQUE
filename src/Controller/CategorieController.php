<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("/categorie")
 */

class CategorieController extends AbstractController
{
    /**
     *@Route("/", name="categorie_list")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            "categories" => $categories,
            'controller_name' => 'CategorieController',
        ]);
    }


    /**
     *@Route("/add", name="add_categorie")
     */
    public function add(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_list');
        }

        return $this->render('categorie/add.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     *@Route("/delete/{id}", name="delete_categorie")
     */
    public function deleteCategorie($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Categorie::class)->find($id);
        if (!$categorie) {
            throw $this->createNotFoundException("Aucune catégorie pour" . $id);
        }

        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("categorie_list");
    }

    /**
     *@Route("/update/{id}", name="update_categorie")
     */
    public function updateCategorie($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Categorie::class)->find($id);

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute("categorie_list");
        }

        return $this->render('categorie/update.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
}

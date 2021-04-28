<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vente")
 */

class VenteController extends AbstractController
{
    /**
     * @Route("/", name="vente")
     */
    public function index(): Response
    {
        $ventes = $this->getDoctrine()->getRepository(Vente::class)->findAll();

        return $this->render('vente/index.html.twig', [
            'ventes' => $ventes,
            'controller_name' => 'VenteController',
        ]);
    }

    /**
     * @Route("/add", name = "add_vente")
     */
    public function addVente(Request $request): Response
    {
        $vente = new Vente();

        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vente);
            $em->flush();

            return $this->redirectToRoute("vente");
        }

        return $this->render('vente/add.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_vente")
     */

    public function deleteArticle($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $vente = $em->getRepository(Vente::class)->find($id);
        $em->remove($vente);
        $em->flush();

        return $this->redirectToRoute("vente");
    }

    /**
     * @Route("update/{id}", name="update_vente")
     */
    public function updateVente($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $vente = $em->getRepository(Vente::class)->find($id);

        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vente);
            $em->flush();

            return $this->redirectToRoute('vente');
        }

        return $this->render('vente/update.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }
}

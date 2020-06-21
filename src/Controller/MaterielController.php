<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class MaterielController extends AbstractController
{
    /**
     * @Route("/", name="materiel_index", methods={"GET"})
     */
    public function index(MaterielRepository $materielRepository): Response
    {
        return $this->render('materiel/index.html.twig', [
            'materiels' => $materielRepository->findAll(),
        ]);
    }

    /**
     * @Route("/materiel/new", name="materiel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materiel);
            $entityManager->flush();

            return $this->redirectToRoute('materiel_index');
        }

        return $this->render('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/materiel/{id}", name="materiel_show", methods={"GET"})
     */
    public function show(Materiel $materiel): Response
    {
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    /**
     * @Route("/materiel/{id}/edit", name="materiel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Materiel $materiel): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('materiel_index');
        }

        return $this->render('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/materiel/{id}", name="materiel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Materiel $materiel): Response
    {
        if ($this->isCsrfTokenValid('delete' . $materiel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($materiel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materiel_index');
    }

    /**
     * @Route("/materiel/{id}/decrease", name="materiel_decrease", methods={"GET","POST"})
     */
    public function decrease(Request $request, Materiel $materiel, $id, \Swift_Mailer $mailer ): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $materiel = $entityManager->getRepository(Materiel::class)->find($id);

        if (!$materiel) {
            throw $this->createNotFoundException(
                'Aucun produit avec cet id ' . $id
            );
        }

        // get the quantity in Materiel entity
        $quantity = $materiel->getQuantite();

        // if the product's quantity is bigger than 0 decrease -1
        if ($quantity > 0) {
            $quantity = $quantity - 1;
            $materiel = $materiel->setQuantite($quantity);
            $entityManager->flush();
        } else {
            //alert when the product's quantity is already at 0
            throw $this->createNotFoundException(
                'Impossible de Décrémenter'
            );
        }

//        If quantity is equal or lower than 0, send an email to the admin
        if ($quantity <= 0) {
            $message = (new \Swift_Message('Module_Materiel'))
                ->setFrom('module_materiel@email.com')
                ->setTo('d4fab93793-631efb@inbox.mailtrap.io')
                ->setBody(
                    $this->renderView(
                        'emails/send.html.twig',
                        ['id' => $materiel]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            // show a successful alert message after the email was sent
            $this->addFlash("success", "Un email d'information à été envoyé à l'admin.");
        }

        return $this->redirectToRoute('materiel_index');

    }

}

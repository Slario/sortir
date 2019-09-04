<?php

namespace App\Controller;


use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\SortieCancelType;
use App\Form\SortieType;
use App\Form\VilleType;
use App\Repository\InscriptionRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class SortieController extends Controller
{
    /**
     * @Route("", name="sortie_index", methods={"GET"})
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sortie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sortie = new Sortie();
        $sortie->setOrganisateur($this->getUser());
        $lieu = new Lieu();
        $ville = new Ville();

        $form = $this->createForm(SortieType::class, $sortie);
        $formLieu = $this->createForm(LieuType::class,$lieu);
        $formVille = $this->createForm(VilleType::class,$ville);


        $form->handleRequest($request);
        $formLieu->handleRequest($request);
        $formVille->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('enregistrer')->isClicked()) {
                $sortie->setEtat('CRE');
            } else {
                $sortie->setEtat('OUV');
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortie);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash("success", "La sortie vient d'être ajoutée en base de donnée");
            return $this->redirectToRoute('sortie_index');
        }

        if ($formLieu->isSubmitted() && $formLieu->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lieu);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash("success", "Le lieu vient d'être ajouté en base de donnée");
        }

        if ($formVille->isSubmitted() && $formVille->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ville);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash("success", "La ville vient d'être ajoutée en base de donnée");
        }

        return $this->render('sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),

            'formLieu' =>$formLieu->createView(),
            'formVille' =>$formVille->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie): Response
    {

        //$id=$sortie->getId();

        //  Avoir la liste des participants d'une sortie


        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sortie $sortie, EntityManagerInterface $entityManager): Response
    {
        $lieu = new Lieu();
        $ville = new Ville();
        $formVille = $this->createForm(VilleType::class,$ville);

        $form = $this->createForm(SortieType::class, $sortie);
        $formLieu = $this->createForm(LieuType::class,$lieu);
        $formVille = $this->createForm(VilleType::class,$ville);

        $formLieu->handleRequest($request);
        $form->handleRequest($request);
        $formVille->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->verifierOrganisateur($sortie)) {
            if ($form->get('annuler')->isClicked()) {

                return $this->redirectToRoute('sortie_cancel', [
                    'sortie' => $sortie,
                    'id' => $sortie->getId(),
                ]);
            }
            $this->getDoctrine()->getManager()->flush();
            // do anything else you need here, like send an email
            $this->addFlash("success", "La sortie vient d'être modifiée en base de donnée");

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
            'formLieu' =>$formLieu->createView(),
            'formVille' =>$formVille->createView()

        ]);
    }

    /**
     * @Route("/{id}/cancel", name="sortie_cancel", methods={"GET","POST"})
     */

    public function cancel(Request $request, Sortie $sortie): Response
    {
        $form = $this->createForm(SortieCancelType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->verifierOrganisateur($sortie)) {

            $entityManager = $this->getDoctrine()->getManager();
            $sortie->setEtat('ANN');
            $entityManager->persist($sortie);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $this->addFlash("success", "La sortie vient d'être annulée");

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/cancel.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sortie $sortie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sortie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sortie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sortie_index');
    }

    /**
     * @Route("/addParticipant/{id}", name="sortie_add_participant", methods={"GET"})
     */
    public function sInscrireAUneSortie(EntityManagerInterface $entityManager, Sortie $sortie)
    {

        $user = $this->getUser();
        $inscription = new Inscription();
        $inscription->setParticipant($user)->setSortie($sortie)->setDateInscription(new \DateTime());
        $user->addInscription($inscription);
        $sortie->addInscription($inscription);
        $entityManager->persist($user);
        $entityManager->persist($sortie);
        $entityManager->persist($inscription);
        $entityManager->flush();

        return $this->redirectToRoute('sortie_index');

    }

    /**
     * @Route("/removeParticipant/{id}", name="sortie_remove_participant", methods={"GET"})
     */
    public function seDesabonnerDUneSortie(EntityManagerInterface $entityManager, InscriptionRepository $inscriptionRepository, Sortie $sortie)
    {

        $user = $this->getUser();
        $inscription = $inscriptionRepository->findOneBy(['participant' => $user, 'sortie' => $sortie]);
        $user->removeInscription($inscription);
        $sortie->removeInscription($inscription);
        $entityManager->remove($inscription);
        $entityManager->persist($user);
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('sortie_index');

    }

    private function verifierOrganisateur(Sortie $sortie)
    {

        if ($sortie->getOrganisateur()->getId() == $this->getUser()->getId()) {
            return true;
        }
        return false;
    }


}

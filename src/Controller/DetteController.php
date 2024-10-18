<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Form\DetteType;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'dette.index', methods: ['GET', 'POST'])]
    public function index(DetteRepository $detteRepository, Request $request): Response
    {
        $status = $request->get('status', 'all');

        if ($status === 'solde') {
            $dettes = $detteRepository->findBy(['montant' => $detteRepository->expr()->eq('montant', 'montantVerser')]);
        } elseif ($status === 'non_solde') {
            $dettes = $detteRepository->findBy(['montantVerser' => $detteRepository->expr()->lt('montantVerser', 'montant')]);
        } else {
            $dettes = $detteRepository->findAll();
        }

        return $this->render('dette/index.html.twig', [
            'dettes' => $dettes,
            'status' => $status,
        ]);
    }

    #[Route('/dette/create', name: 'dette.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dette = new Dette();
        $form = $this->createForm(DetteType::class, $dette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dette);
            $entityManager->flush();

            return $this->redirectToRoute('dette.index');
        }

        return $this->render('dette/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

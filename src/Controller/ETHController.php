<?php

namespace App\Controller;

use App\Entity\ETH;
use App\Form\ETHType;
use App\Repository\ETHRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/eth')]
class ETHController extends AbstractController
{

    // AFFICHER TOUS LES ETH
    #[Route('/', name: 'app_eth_index', methods: ['GET'])]
    public function apiEth(EntityManagerInterface $entityManagerInterface): Response
    {
        $eths = $entityManagerInterface->getRepository(ETH::class)->findAll();

        return $this->json($eths);
    }

    // CREER UN NOUVEAU ETH
    #[Route('/new', name: 'app_eth_new_api', methods: ['POST'])]
    public function newApi(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['price']) || !isset($data['date'])) {
            return new Response('Tous les champs doivent être remplis');
        }

        if ($data["price"] == !null && $data["date"] == !null) {

            $datePost = $data["date"];
            $datePost = date_parse_from_format("Y-m-d", $datePost);

            $date = new DateTime();
            $date->setDate($datePost["year"], $datePost["month"], $datePost["day"]);

            $eth = new Eth();
            $eth->setPrice($data["price"]);
            $eth->setDate($date);

            $entityManager->persist($eth);
            $entityManager->flush();

            return new Response('ETH créé');
        } else {
            return new Response("Erreur, l'Eth n'a pas été créé");
        }
    }

    // #[Route('/{id}', name: 'app_eth_show', methods: ['GET'])]
    // public function show(ETH $eTH): Response
    // {
    //     return $this->render('eth/show.html.twig', [
    //         'eth' => $eTH,
    //     ]);
    // }

    // VOIR 1 ETH
    #[Route('/{id}', name: 'app_eth_show')]
    public function apiEthId($id, ETHRepository $eTHRepository): Response
    {
        $eth = $eTHRepository->find($id);
        return $this->json($eth, 200, [], ['groups' => 'ethAll']);
    }

    // #[Route('/{id}/edit', name: 'app_e_t_h_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, ETH $eTH, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ETHType::class, $eTH);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_eth_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('eth/edit.html.twig', [
    //         'eth' => $eTH,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_eth_delete', methods: ['POST'])]
    // public function delete(Request $request, ETH $eTH, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $eTH->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($eTH);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_eth_index', [], Response::HTTP_SEE_OTHER);
    // }
}

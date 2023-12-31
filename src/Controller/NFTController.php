<?php

namespace App\Controller;

use App\Entity\NFT;
use App\Form\NFTType;
use App\Repository\NFTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/nft')]
class NFTController extends AbstractController
{

    #[Route('/', name: 'app_nft_index')]
    public function apiNft(NFTRepository $nFTRepository): Response
    {
        $nfts = $nFTRepository->findAll();
        return $this->json($nfts, 200, [], ['groups' => 'nftAll']);
    }

    // #[Route('/new', name: 'app_nft_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $nFT = new NFT();
    //     $form = $this->createForm(NFTType::class, $nFT);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($nFT);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('nft/new.html.twig', [
    //         'nft' => $nFT,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/new', name: 'app_nft_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        // Créer une instance de Category à partir des données JSON
        $nft = new NFT();
        $form = $this->createForm(NFTType::class, $nft);

        // Soumettre les données JSON au formulaire
        $form->submit($data);

        // Valider le formulaire
        if ($form->isValid()) {
            // Persistez la catégorie en base de données
            $entityManager->persist($nft);
            $entityManager->flush();

            // Renvoyer une réponse JSON de succès
        }
        return $this->json($nft);
    }


    #[Route('/{id}', name: 'app_nft_show', methods: ['GET'])]
    public function apiNftId($id, NFTRepository $nFTRepository): Response
    {
        $nft = $nFTRepository->find($id);
        return $this->json($nft, 200, [], ['groups' => 'nftAll']);
    }

    // #[Route('/{id}/edit', name: 'app_nft_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, NFT $nFT, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(NFTType::class, $nFT);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('nft/edit.html.twig', [
    //         'nft' => $nFT,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_nft_delete', methods: ['DELETE'])]
    public function delete($id, NFTRepository $nFTRepository, EntityManagerInterface $entityManager): Response
    {
        $nft = $nFTRepository->find($id);

        $entityManager->remove($nft);
        $entityManager->flush();

        return new Response('le nft a été supprimé');
    }
}

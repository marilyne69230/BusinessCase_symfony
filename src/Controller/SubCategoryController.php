<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/subcategory')]
class SubCategoryController extends AbstractController
{
    #[Route('/', name: 'app_sub_category_index')]
    public function apiGallery(SubCategoryRepository $subCategoryRepository): Response
    {
        $subCategories = $subCategoryRepository->findAll();
        return $this->json($subCategories, 200, [], ['groups' => 'subCatAll']);
    }

    // #[Route('/new', name: 'app_sub_category_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $subCategory = new SubCategory();
    //     $form = $this->createForm(SubCategoryType::class, $subCategory);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($subCategory);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('sub_category/new.html.twig', [
    //         'sub_category' => $subCategory,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_sub_category_show', methods: ['GET'])]
    // public function show(SubCategory $subCategory): Response
    // {
    //     return $this->render('sub_category/show.html.twig', [
    //         'sub_category' => $subCategory,
    //     ]);
    // }
    #[Route('/{id}', name: 'app_sub_category_show', methods:['GET'])]
    public function apiSubcategoryId($id, SubCategoryRepository $subCategoryRepository): Response
    {
        $subcategory = $subCategoryRepository->find($id);
        return $this->json($subcategory, 200, [], ['groups' => 'subCatAll']);
    }

    // #[Route('/{id}/edit', name: 'app_sub_category_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, SubCategory $subCategory, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(SubCategoryType::class, $subCategory);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('sub_category/edit.html.twig', [
    //         'sub_category' => $subCategory,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_sub_category_delete', methods: ['DELETE'])]
    public function delete($id, SubCategoryRepository $subCategory, EntityManagerInterface $entityManager): Response
    {
        $subCategory = $subCategory->find($id);

        $nfts = $subCategory->getNfts();

        foreach ($nfts as $nft){
            $entityManager->remove($nft);
        }

        $entityManager->remove($subCategory);
        $entityManager->flush();

        return new Response('le sousCat est supprimée');
    }
}

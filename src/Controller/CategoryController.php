<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/api/category')]
class CategoryController extends AbstractController
{

    #[Route('/', name: 'api_category_all')]
    public function apiCategory(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200, [], ['groups' => 'catAll']);
    }

    // #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $category = new Category();
    //     $form = $this->createForm(CategoryType::class, $category);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($category);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('category/new.html.twig', [
    //         'category' => $category,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/new', name: 'app_category_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        // Créer une instance de Category à partir des données JSON
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        // Soumettre les données JSON au formulaire
        $form->submit($data);

        // Valider le formulaire
        if ($form->isValid()) {
            // Persistez la catégorie en base de données
            $entityManager->persist($category);
            $entityManager->flush();

            // Renvoyer une réponse JSON de succès
        }
        return $this->json($category);
    }



    // #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    // public function show(Category $category): Response
    // {
    //     return $this->render('category/show.html.twig', [
    //         'category' => $category,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function apiCategoryId($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        return $this->json($category, 200, [], ['groups' => 'catAll']);
    }

    // #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(CategoryType::class, $category);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('category/edit.html.twig', [
    //         'category' => $category,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    // public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($category);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    // }

    // SUPPRIMER UNE CATEGORIE
    #[Route('/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $entityManager): JsonResponse
    {

        $entityManager->remove($category);
        $entityManager->flush();

        return new JsonResponse;
    }
}

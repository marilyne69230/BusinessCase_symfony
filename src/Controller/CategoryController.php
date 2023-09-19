<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
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

    // Ajouter 1 category
    #[Route('/new', name: 'app_category_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if(isset($data['label'] ) !== null){
            $category = new Category();

            $category->setLabel($data['label']);

            $entityManager->persist($category);
            $entityManager->flush();

            return new Response();
        }
        return new Response();

    }

    // Voir 1 category
    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function apiCategoryId($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        return $this->json($category, 200, [], ['groups' => 'catAll']);
    }

    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if(isset($data['label'] )){

            $category->setLabel($data['label']);

            $entityManager->persist($category);
            $entityManager->flush();

            return new Response("success");
        }
        return new Response("error");
    }

    // SUPPRIMER UNE CATEGORIE
    #[Route('/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $entityManager): JsonResponse
    {

        $entityManager->remove($category);
        $entityManager->flush();

        return new JsonResponse;
    }
}

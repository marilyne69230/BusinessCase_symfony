<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Repository\GalleryRepository;
use ContainerC8uPi34\getGalleryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/gallery')]
class GalleryController extends AbstractController
{

    #[Route('/', name: 'app_gallery_index')]
    public function apiGallery(GalleryRepository $galleryRepository): Response
    {
        $galleries = $galleryRepository->findAll();
        return $this->json($galleries, 200, [], ['groups' => 'galAll']);
    }

    // #[Route('/new', name: 'app_gallery_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $gallery = new Gallery();
    //     $form = $this->createForm(GalleryType::class, $gallery);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($gallery);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('gallery/new.html.twig', [
    //         'gallery' => $gallery,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_gallery_show', methods: ['GET'])]
    // public function show(Gallery $gallery): Response
    // {
    //     return $this->render('gallery/show.html.twig', [
    //         'gallery' => $gallery,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_gallery_show')]
    public function apiGalleryId($id, GalleryRepository $galleryRepository): Response
    {
        $gallery = $galleryRepository->find($id);
        return $this->json($gallery, 200, [], ['groups' => 'galAll']);
    }

    // #[Route('/{id}/edit', name: 'app_gallery_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Gallery $gallery, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(GalleryType::class, $gallery);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('gallery/edit.html.twig', [
    //         'gallery' => $gallery,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_gallery_delete', methods: ['POST'])]
    // public function delete(Request $request, Gallery $gallery, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($gallery);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
    // }
}

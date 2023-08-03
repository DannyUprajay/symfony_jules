<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/publication')]
class PublicationController extends AbstractController
{


    public function __construct(
        private PublicationRepository $publicationRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/', name: 'app_publication')]
    public function index(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_publication_show')]
    public function detail($id, Request $request): Response
    {
        $publicationEntities = $this->publicationRepository->find($id);

        if($publicationEntities === null){
            return $this->redirectToRoute('app_publication');
        }

        $comment = new Comment();
        $comment->setCreatedAt(new \DateTime());
        $comment->setPublications($publicationEntities);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_publication');
        }

        return $this->render('publication/show.html.twig', [
            'publication' => $publicationEntities,
            'form' => $form->createView()
        ]);


    }
}
<?php

namespace App\Controller;

use App\Entity\LinkType;
use App\Form\LinkTypeType;
use App\Repository\LinkTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/link/type')]
class LinkTypeController extends AbstractController
{
    #[Route('/', name: 'app_link_type_index', methods: ['GET'])]
    public function index(LinkTypeRepository $linkTypeRepository): Response
    {
        return $this->render('link_type/index.html.twig', [
            'link_types' => $linkTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_link_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LinkTypeRepository $linkTypeRepository): Response
    {
        $linkType = new LinkType();
        $form = $this->createForm(LinkTypeType::class, $linkType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $linkTypeRepository->add($linkType);
            return $this->redirectToRoute('app_link_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link_type/new.html.twig', [
            'link_type' => $linkType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_link_type_show', methods: ['GET'])]
    public function show(LinkType $linkType): Response
    {
        return $this->render('link_type/show.html.twig', [
            'link_type' => $linkType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_link_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LinkType $linkType, LinkTypeRepository $linkTypeRepository): Response
    {
        $form = $this->createForm(LinkTypeType::class, $linkType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $linkTypeRepository->add($linkType);
            return $this->redirectToRoute('app_link_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link_type/edit.html.twig', [
            'link_type' => $linkType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_link_type_delete', methods: ['POST'])]
    public function delete(Request $request, LinkType $linkType, LinkTypeRepository $linkTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$linkType->getId(), $request->request->get('_token'))) {
            $linkTypeRepository->remove($linkType);
        }

        return $this->redirectToRoute('app_link_type_index', [], Response::HTTP_SEE_OTHER);
    }
}

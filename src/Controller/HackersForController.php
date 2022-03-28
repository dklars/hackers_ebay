<?php

namespace App\Controller;

use App\Entity\HackersFor;
use App\Form\HackersForType;
use App\Repository\HackersForRepository;
use App\Repository\LinkTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hackers/for')]
class HackersForController extends AbstractController
{
    #[Route('/', name: 'app_hackers_for_index', methods: ['GET'])]
    public function index(HackersForRepository $hackersForRepository): Response
    {
        return $this->render('hackers_for/index.html.twig', [
            'hackers_fors' => $hackersForRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hackers_for_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HackersForRepository $hackersForRepository, LinkTypeRepository $linkTypeRepository): Response
    {
        $hackersFor = new HackersFor();
        $form = $this->createForm(HackersForType::class, $hackersFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = "EBAY";
            $linkType = $linkTypeRepository->findOneBy(["nameLink"=>$type]);
            $lastHackers = $hackersForRepository->findOneBy(["linkType"=>$linkType], ["id"=>"DESC"]);
            dump($lastHackers);
            if($lastHackers){ $lastId = $lastHackers->getId() + 1; } else { $lastId = 1; }
            $hackersFor->setNombre(0);
            $hackersFor->setName(strtolower($type)."000".$lastId);
            $hackersFor->setActivated(true);
            $hackersForRepository->add($hackersFor);
            return $this->redirectToRoute('app_hackers_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hackers_for/new.html.twig', [
            'hackers_for' => $hackersFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hackers_for_show', methods: ['GET'])]
    public function show(HackersFor $hackersFor): Response
    {
        return $this->render('hackers_for/show.html.twig', [
            'hackers_for' => $hackersFor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hackers_for_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HackersFor $hackersFor, HackersForRepository $hackersForRepository): Response
    {
        $form = $this->createForm(HackersForType::class, $hackersFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hackersForRepository->add($hackersFor);
            return $this->redirectToRoute('app_hackers_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hackers_for/edit.html.twig', [
            'hackers_for' => $hackersFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hackers_for_delete', methods: ['POST'])]
    public function delete(Request $request, HackersFor $hackersFor, HackersForRepository $hackersForRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hackersFor->getId(), $request->request->get('_token'))) {
            $hackersForRepository->remove($hackersFor);
        }

        return $this->redirectToRoute('app_hackers_for_index', [], Response::HTTP_SEE_OTHER);
    }
}

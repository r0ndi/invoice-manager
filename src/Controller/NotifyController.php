<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class NotifyController extends Controller
{
    public function notify(): Response
    {
        return $this->render('controller/notify/notify.html.twig', [
            'messages' => $this->getServiceLocator()->getNotifyService()->getMessages()
        ]);
    }
}
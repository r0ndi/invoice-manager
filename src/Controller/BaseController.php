<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public function header(): Response
    {
        return $this->render('controller/base/header.html.twig');
    }

    public function navigation(): Response
    {
        return $this->render('controller/base/navigation.html.twig');
    }
}
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function home(): Response
    {
        return $this->render('controller/home/home.html.twig');
    }
}
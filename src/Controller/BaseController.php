<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public function header(): Response
    {
        return $this->render('base/header.html.twig');
    }
}
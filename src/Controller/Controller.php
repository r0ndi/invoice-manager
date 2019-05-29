<?php

namespace App\Controller;

use App\Util\ServiceLocator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class Controller extends AbstractController
{
    private $serviceLocator;

    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator(): ServiceLocator
    {
        return $this->serviceLocator;
    }
}
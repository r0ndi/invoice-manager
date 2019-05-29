<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Service
{
    /** @var ContainerInterface $container */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getTwig(): \Twig_Environment
    {
        $twig = $this->container->get('twig');
        return $twig instanceof \Twig_Environment ? $twig : null;
    }
}
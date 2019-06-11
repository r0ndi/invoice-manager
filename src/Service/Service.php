<?php

namespace App\Service;

use App\Exception\InvoiceManagerException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig_Environment;

abstract class Service
{
    /** @var ContainerInterface $container */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getTwig(): Twig_Environment
    {
        $twig = $this->container->get('twig');
        if ($twig instanceof Twig_Environment) {
            return $twig;
        }

        throw new InvoiceManagerException('Twig container not found');
    }

    protected function getSession(): Session
    {
        $session = $this->container->get('session');
        if ($session instanceof Session) {
            return $session;
        }

        throw new InvoiceManagerException('Session container not found');
    }
}
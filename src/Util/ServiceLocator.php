<?php

namespace App\Util;

use App\Service\InvoiceService;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ServiceLocator
{
    /** @var ContainerInterface $container */
    private $container;
    private $services = [];

    public function __construct(KernelInterface $kernel)
    {
        $this->container = $kernel->getContainer();

        $this->setUp();
    }

    public function getInvoiceService(): InvoiceService
    {
        return $this->services['invoiceService'];
    }

    private function setUp(): void
    {
        $this->services['invoiceService'] = new InvoiceService($this->container);
    }
}
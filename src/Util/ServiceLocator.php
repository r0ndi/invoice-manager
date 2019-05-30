<?php

namespace App\Util;

use App\Service\DocumentService\DocumentFactory;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceLocator
{
    private $container;
    private $translator;
    private $services = [];

    public function __construct(KernelInterface $kernel, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->container = $kernel->getContainer();

        $this->setUp();
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getDocumentService(): DocumentFactory
    {
        return $this->services['documentService'];
    }

    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    private function setUp(): void
    {
        $this->services['documentService'] = new DocumentFactory($this->getContainer());
    }
}
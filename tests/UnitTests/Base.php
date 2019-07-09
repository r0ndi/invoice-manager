<?php

namespace App\Tests\UnitTests;

use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Base extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    protected function getEntityManager(): ?ObjectManager
    {
        $entityManager = $this->getClient()->getContainer()->get('doctrine');

        if ($entityManager instanceof Registry) {
            return $entityManager->getManager();
        }

        return null;
    }
}
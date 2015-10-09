<?php

namespace Innova\SelfBundle\Library\Testing;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class TransactionalTestCase extends WebTestCase
{
    /** 
     * @var TransactionalTestClient 
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->client->beginTransaction();
    }

    protected function tearDown()
    {
        $this->client->shutdown();
        parent::tearDown();
    }
}
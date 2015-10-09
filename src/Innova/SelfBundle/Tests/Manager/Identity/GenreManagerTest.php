<?php

namespace Innova\SelfBundle\Tests\Manager\Identity;

use Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre;
use Innova\SelfBundle\Manager\Identity\GenreManager;
use Innova\SelfBundle\Library\Testing\TransactionalTestCase;

class GenreManagerTest extends TransactionalTestCase
{ 
    public function setUp()
    {
        parent::setUp();
        
        $container = $this->client->getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->genreManager = new GenreManager($this->entityManager);
        $this->genreRepository = $this->entityManager->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Genre');
    }

    public function testCreate()
    {
        $this->assertNull(
            $this->genreRepository->findOneByName('thisisatestname')
        );

        $this->assertNull(
            $this->genreRepository->findOneByName('thisisanothertestname')
        );

        $this->assertTrue(
            $this->genreManager->create(
                array(
                    "thisisatestname",
                    "thisisanothertestname"
                )
            )
        );

        $this->assertEquals(
            'thisisatestname',
            $this->genreRepository->findOneByName('thisisatestname')->getName()
        );

        $this->assertEquals(
            'thisisanothertestname',
            $this->genreRepository->findOneByName('thisisanothertestname')->getName()
        );
    }

    public function testDelete()
    {
        $this->assertNull(
            $this->genreRepository->findOneByName('thisisatestname')
        );

        $genre = new Genre();
        $genre->setName('thisisatestname');
        $this->entityManager->persist($genre);
        $this->entityManager->flush();

        $this->assertEquals(
            'thisisatestname',
            $this->genreRepository->findOneByName('thisisatestname')->getName()
        );

        $this->assertTrue(
            $this->genreManager->delete(
                array(
                    "thisisatestname"
                )
            )
        );

        $this->assertNull(
            $this->genreRepository->findOneByName('thisisatestname')
        );
    }
}
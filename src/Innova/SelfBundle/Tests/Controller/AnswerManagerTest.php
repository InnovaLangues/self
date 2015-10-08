<?php

use Innova\SelfBundle\Manager\AnswerManager;

class AnswerManagerTest extends \PHPUnit_Framework_TestCase
{
	public function testCreateAnswer()
    {


    $trace = $this->getMock('Innova\SelfBundle\Entity\Trace');
        /*$answer->expects($this->once())
            ->method('getSalary')
            ->will($this->returnValue(1000));*/


    // Now, mock the repository so it returns the mock of the employee
/*
    $employeeRepository = $this
        ->getMockBuilder('\Doctrine\ORM\EntityRepository')
        ->disableOriginalConstructor()
        ->getMock();
    $employeeRepository->expects($this->once())
        ->method('find')
        ->will($this->returnValue($employee));
*/

    	// Last, mock the EntityManager to return the mock of the repository

	    $entityManager = $this
	        ->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
	        ->disableOriginalConstructor()
	        ->getMock();
	    /*$entityManager->expects($this->once())
	        ->method('getRepository')
	        ->will($this->returnValue($employeeRepository));*/


    	$AnswerManager = new AnswerManager($entityManager);
    	$this->assertEquals(2100, $AnswerManager->createAnswer($trace));
	}
}
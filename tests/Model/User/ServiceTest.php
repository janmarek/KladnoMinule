<?php

namespace KladnoMinule\Tests\Model\User;

use KladnoMinule\Model\User\Service;

/**
 * User service test
 */
class ServiceTest extends \Neuron\Testing\ServiceTestCase
{
	/**
	 * @var KladnoMinule\Model\User\Service
	 */
	protected $object;



	protected function setUp()
	{
		$this->object = new Service($this->getEntityManager());
	}



	protected function tearDown()
	{

	}

}

<?php

namespace KladnoMinule\Tests\Model\Page;

use KladnoMinule\Model\Page\Service;

/**
 * Page service test
 */
class ServiceTest extends \Neuron\Testing\ServiceTestCase
{
	/**
	 * @var KladnoMinule\Model\Page\Service
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

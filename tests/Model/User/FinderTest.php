<?php

namespace KladnoMinule\Tests\Model\User;

use KladnoMinule\Model\User\Finder;

/**
 * User service test
 */
class FinderTest extends \Neuron\Testing\FinderTestCase
{
	/**
	 * @var KladnoMinule\Model\User\Finder
	 */
	protected $object;



	protected function setUp()
	{
		$serviceMock = $this->getServiceMock('KladnoMinule\Model\User\Service', 'KladnoMinule\Model\User\User');
		$this->object = new Finder($serviceMock);
	}



	protected function tearDown()
	{

	}

}

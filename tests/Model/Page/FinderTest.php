<?php

namespace KladnoMinule\Tests\Model\Page;

use KladnoMinule\Model\Page\Finder;

/**
 * Page service test
 */
class FinderTest extends \Neuron\Testing\FinderTestCase
{
	/**
	 * @var KladnoMinule\Model\Page\Finder
	 */
	protected $object;



	protected function setUp()
	{
		$serviceMock = $this->getServiceMock('KladnoMinule\Model\Page\Service', 'KladnoMinule\Model\Page\Page');
		$this->object = new Finder($serviceMock);
	}



	protected function tearDown()
	{

	}

}

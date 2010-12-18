<?php

namespace KladnoMinule\Tests\Model\Page;

use KladnoMinule\Model\Page\Page;

/**
 * Page entity test
 */
class PageTest extends \Neuron\Testing\TestCase
{
	/**
	 * @var KladnoMinule\Model\Page\Page
	 */
	protected $object;



	protected function setUp()
	{
		$this->object = new Page;
	}



	public function testSetTags()
	{
		$tag1 = $this->getMock('KladnoMinule\Model\Tag\Tag');
		$tag2 = $this->getMock('KladnoMinule\Model\Tag\Tag');
		$tag3 = $this->getMock('KladnoMinule\Model\Tag\Tag');

		$tag1->expects($this->once())->method('increase');
		$tag1->expects($this->once())->method('decrease');

		$tag2->expects($this->once())->method('increase');
		$tag2->expects($this->never())->method('decrease');

		$tag3->expects($this->once())->method('increase');
		$tag3->expects($this->never())->method('decrease');


		$this->object->setTags(array($tag1, $tag3));
		$this->object->setTags(array($tag2, $tag3));
	}

}

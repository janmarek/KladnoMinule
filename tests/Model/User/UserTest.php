<?php

namespace KladnoMinule\Tests\Model\User;

use KladnoMinule\Model\User\User;

/**
 * User entity test
 */
class UserTest extends \Neuron\Testing\TestCase
{
	/**
	 * @var KladnoMinule\Model\User\User
	 */
	protected $object;



	protected function setUp()
	{
		$this->object = new User;
	}



	protected function tearDown()
	{

	}



	public function testUserInitialState()
	{
		$this->assertNotEmpty($this->object->getHash());
		$this->assertFalse($this->object->isActive());
	}



	public function testSetUserActiveSetsHashNull()
	{
		$this->object->setActive(true);
		$this->assertNull($this->object->getHash());
	}



	public function testVerifyPassword()
	{
		$this->object->setPassword("123456");
		$this->assertTrue($this->object->verifyPassword("123456"));
		$this->assertFalse($this->object->verifyPassword("qwerty"));
	}



	public function testVerifyMD5Password()
	{
		$this->object->setPassword("123456", "md5");
		$this->assertTrue($this->object->verifyPassword("123456"));
		$this->assertFalse($this->object->verifyPassword("qwerty"));
	}



	public function testNullPassword()
	{
		$this->object->setPassword(null);
		$this->assertFalse($this->object->verifyPassword(null));
	}


	public function testVerifyPassWithEmptySalt()
	{
		$passRefl = $this->object->getReflection()->getProperty("password");
		$passRefl->setAccessible(true);
		$passRefl->setValue($this->object, '$' . md5('pass') . '$md5');
		$this->assertTrue($this->object->verifyPassword('pass'));
		$this->assertFalse($this->object->verifyPassword('wrongpass'));
	}

}

<?php

namespace KladnoMinule\Model\User;

use DateTime;

/**
 * User entity
 *
 * @author Jan Marek
 *
 * @Entity
 * @Table(name="kmuser")
 */
class User extends \Neuron\Model\BaseEntity
{
	/**
	 * @Column
	 * @validation:NotBlank
	 */
	private $name;

	/**
	 * @Column(unique=true, nullable=true)
	 * @validation:Email
	 */
	private $mail;

	/**
	 * @Column
	 * @validation:NotBlank
	 */
	private $role;

	/** @Column(type="boolean") */
	private $active = false;

	/** @Column(nullable=true) */
	private $hash;

	/**
	 * @Column(nullable=true)
	 */
	private $password;

	/** @Column(type="datetime") */
	private $created;



	public function __construct(array $values = array())
	{
		$this->created = new DateTime;
		$this->hash = md5(uniqid("", true));
		parent::__construct($values);
	}



	public function getName()
	{
		return $this->name;
	}



	public function setName($name)
	{
		$this->name = $name;
	}



	public function getMail()
	{
		return $this->mail;
	}



	public function setMail($mail)
	{
		$this->mail = $mail;
	}



	public function getHash()
	{
		return $this->hash;
	}



	public function verifyHash($hash)
	{
		return $this->hash === $hash;
	}



	public function verifyPassword($password)
	{
		if ($this->password === null) {
			return false;
		}

		list($salt, $hash, $hashFunction) = explode('$', $this->password);
		return $hash === $hashFunction($salt . $password);
	}



	public function setPassword($password, $hashFunction = "sha1")
	{
		if ($password === null) {
			$this->password = null;
		} else {
			$salt = md5(uniqid("", true));
			$hash = $hashFunction($salt . $password);
			$this->password = $salt . '$' . $hash . '$' . $hashFunction;
		}
	}



	public function setActive($active)
	{
		$this->active = (bool) $active;
		if ($this->active) {
			$this->hash = null;
		}
	}



	public function isActive()
	{
		return $this->active;
	}



	public function getCreated()
	{
		return $this->created;
	}



	public function setRole($role)
	{
		$this->role = $role;
	}



	public function getRole()
	{
		return $this->role;
	}

}
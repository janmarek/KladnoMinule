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
	 * @validation:NotBlank(message="Jméno není vyplněné.")
	 */
	private $name;

	/**
	 * @Column(unique=true, nullable=true)
	 * @validation:Email(message="E-mail není vyplněn.")
	 * @validation:Unique(message="E-mail není unikátní.")
	 */
	private $mail;

	/**
	 * @Column
	 * @validation:NotBlank(message="Role není vyplněna.")
	 */
	private $role = 'user';

	/** @Column(type="boolean") */
	private $active = false;

	/** @Column(nullable=true, unique=true) */
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
		parent::__construct($values);
		$this->setNewHash();
	}



	public function setNewHash()
	{
		$this->hash = md5(uniqid("", true));
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
		$this->mail = $mail ?: null;
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
			$this->hash = null;
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
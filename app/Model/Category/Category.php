<?php

namespace KladnoMinule\Model\Category;

/**
 * Category entity
 *
 * @author Jan Marek
 *
 * @Entity
 * @Table(name="category")
 */
class Category extends \Neuron\Model\BaseEntity
{
	/**
	 * @Column
	 * @validation:NotBlank
	 */
	private $name;

	/**
	 * @Column(unique=true)
	 * @validation:NotBlank
	 */
	private $url;

	/** @Column(type="text", nullable=true) */
	private $description;



	public function setDescription($description)
	{
		$this->description = $description;
	}



	public function getDescription()
	{
		return $this->description;
	}



	public function setName($name)
	{
		$this->name = $name;
		$this->url = \Nette\String::webalize($name);
	}



	public function getName()
	{
		return $this->name;
	}



	public function getUrl()
	{
		return $this->url;
	}

}
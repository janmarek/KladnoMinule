<?php

namespace KladnoMinule\Model\Language;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Language entity
 *
 * @author Jan Marek
 *
 * @Entity
 * @Table(name="language")
 */
class Language extends \Neuron\Model\BaseEntity
{
	/**
	 * @Column(unique=true)
	 * @validation:NotBlank
	 */
	private $url;

	/**
	 * @Column
	 * @validation:NotBlank
	 */
	private $name;



	public function setName($name)
	{
		$this->name = $name;
	}



	public function getName()
	{
		return $this->name;
	}



	public function setUrl($url)
	{
		$this->url = $url;
	}



	public function getUrl()
	{
		return $this->url;
	}


}
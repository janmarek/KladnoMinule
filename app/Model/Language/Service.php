<?php

namespace KladnoMinule\Model\Language;

/**
 * Language service
 *
 * @author Jan Marek
 */
class Service extends \Neuron\Model\Service
{
	public function __construct($em)
	{
		parent::__construct($em, __NAMESPACE__ . '\Language');
	}



	public function getFinder()
	{
		return new Finder($this);
	}


	public function findOneByUrl($url)
	{
		return $this->getFinder()->whereUrl($url)->getSingleResult();
	}



	public function getDictionary()
	{
		return $this->getFinder()->fetchPairs('id', 'name');
	}

}
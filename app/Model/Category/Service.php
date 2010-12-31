<?php

namespace KladnoMinule\Model\Category;

/**
 * Category service
 *
 * @author Jan Marek
 */
class Service extends \Neuron\Model\Service
{
	public function __construct($em)
	{
		parent::__construct($em, __NAMESPACE__ . "\Category");
	}



	public function getFinder()
	{
		return new Finder($this);
	}



	public function getDictionary()
	{
		return $this->getFinder()->fetchPairs('id', 'name');
	}



	public function getUrlDictionary()
	{
		return $this->getFinder()->fetchPairs('id', 'url');
	}

}
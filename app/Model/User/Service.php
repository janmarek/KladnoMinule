<?php

namespace KladnoMinule\Model\User;

/**
 * User service
 *
 * @author Jan Marek
 */
class Service extends \Neuron\Model\Service
{
	public function __construct($em)
	{
		parent::__construct($em, __NAMESPACE__ . "\User");
	}



	public function getFinder()
	{
		return new Finder($this);
	}



	public function findOneByMail($mail)
	{
		return $this->getFinder()->whereMail($mail)->getSingleResult();
	}



	public function getDictionary()
	{
		return $this->getFinder()->fetchPairs('id', 'name');
	}

}
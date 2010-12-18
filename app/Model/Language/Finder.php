<?php

namespace KladnoMinule\Model\Language;

/**
 * Language finder
 *
 * @author Jan Marek
 */
class Finder extends \Neuron\Model\EntityFinder
{
	protected $alias = "l";



	public function whereUrl($url)
	{
		$this->qb->andWhere('l.url = :url')->setParameter('url', $url);
		return $this;
	}

}
<?php

namespace KladnoMinule\Model\User;

/**
 * User finder
 *
 * @author Jan Marek
 */
class Finder extends \Neuron\Model\EntityFinder
{
	protected $alias = "u";



	public function whereMail($mail)
	{
		$this->qb->andWhere("u.mail = :mail")->setParameter("mail", $mail);
		return $this;
	}



	public function whereHash($hash)
	{
		$this->qb->andWhere("u.hash = :hash")->setParameter("hash", $hash);
		return $this;
	}



	public function whereActive()
	{
		$this->qb->andWhere("u.active = true");
	}

}
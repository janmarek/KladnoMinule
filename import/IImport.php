<?php

namespace Kladnominule\Import;


interface IImport
{
	public function clear(\Doctrine\ORM\EntityManager $em);

	public function init(\Doctrine\ORM\EntityManager $em);

	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em);
}

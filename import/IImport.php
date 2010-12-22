<?php

namespace Kladnominule\Import;


interface IImport
{
	public function clear(\Doctrine\ORM\EntityManager $em);

	public function init(\Doctrine\ORM\EntityManager $em);

	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em);
}



abstract class AbstractImport implements IImport
{
	private $map = array();



	public function setPrivateValue($object, $property, $value, $class = null)
	{
		if (!$class) $class = get_class($object);
		$reflection = new \ReflectionProperty($class, $property);
		$reflection->setAccessible(TRUE);
		$reflection->setValue($object, $value);
		$reflection->setAccessible(FALSE);
	}



	protected function addToMap($entity, $id)
	{
		$this->map[(int) $id] = $entity;
	}



	public function getImportedMap()
	{
		return $this->map;
	}



	protected function persist($em, $entity, $id)
	{
		$em->persist($entity);
		$this->addToMap($entity, $id);
	}

}

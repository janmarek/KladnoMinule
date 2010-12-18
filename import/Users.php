<?php

namespace KladnoMinule\Import;

require_once __DIR__ . '/IImport.php';

class Users implements IImport
{
	public function clear(\Doctrine\ORM\EntityManager $em)
	{
		$em->createQuery('delete KladnoMinule\Model\User\User u')->execute();
		echo "Users deleted.\n";
	}

	public function init(\Doctrine\ORM\EntityManager $em)
	{

	}

	public function import(\DibiConnection $dibi, \Doctrine\ORM\EntityManager $em)
	{
		echo "Started importing users.\n";

		$res = $dibi->query("select * from author");
		$res->setType('datetime_create', \dibi::DATETIME);
		$users = $res->fetchAll();

		foreach ($users as $user) {
			$userEntity = new \KladnoMinule\Model\User\User(array(
				'name' => $user->name,
				'mail' => $user->mail ?: null,
				'role' => $user->admin == 1 ? 'admin' : (!empty($user->mail) ? 'user' : 'author'),
				'active' => $user->active == 1,
			));

			// set created
			$createdReflection = $userEntity->getReflection()->getProperty('created');
			$createdReflection->setAccessible(true);
			if ($user->datetime_create) {
				$created = $user->datetime_create;
			} else {
				$created = new \DateTime;
				$created->setDate(2008, 1, 1);
			}
			$createdReflection->setValue($userEntity, $created);

			// set password
			$passReflection = $userEntity->getReflection()->getProperty('password');
			$passReflection->setAccessible(true);
			$pass = $user->password ? '$' . $user->password . '$md5' : null;
			$passReflection->setValue($userEntity, $pass);

			// set hash
			if (!$userEntity->isActive()) {
				$hashReflection = $userEntity->getReflection()->getProperty('hash');
				$hashReflection->setAccessible(true);
				$hashReflection->setValue($userEntity, $user->hash);
			}

			$em->persist($userEntity);

			//echo "User " . $userEntity->getName() . " imported.\n";
		}

		$em->flush();
		echo "Users imported.\n";
	}
}
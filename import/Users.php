<?php

namespace KladnoMinule\Import;

use KladnoMinule\Model\User\User;

require_once __DIR__ . '/IImport.php';

class Users extends AbstractImport
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
			$role = $user->admin == 1 ? 'admin' : (!empty($user->mail) ? 'user' : 'author');

			$userEntity = new User(array(
				'name' => $user->name,
				'mail' => $user->mail ?: null,
				'role' => $role,
				'active' => $user->active == 1,
			));

			// created
			if ($user->datetime_create) {
				$created = $user->datetime_create;
			} else {
				$created = new \DateTime;
				$created->setDate(2008, 1, 1);
			}
			$this->setPrivateValue($userEntity, 'created', $created);

			// set password
			$pass = $user->password ? '$' . $user->password . '$md5' : null;
			$this->setPrivateValue($userEntity, 'password', $pass);

			// set hash
			$this->setPrivateValue($userEntity, 'hash', $userEntity->isActive() ? null : $user->hash);

			$this->persist($em, $userEntity, $user->id);

			echo ".";
		}

		$em->flush();
		echo "\nUsers imported.\n";
	}
}
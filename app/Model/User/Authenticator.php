<?php

namespace KladnoMinule\Model;

use Nette\Security\Identity, Nette\Security\AuthenticationException;

class Authenticator implements \Nette\Security\IAuthenticator
{
	/** @var KladnoMinule\Model\User\Service */
	private $userService;



	public function __construct($userService)
	{
		$this->userService = $userService;
	}



	/**
	 * Performs an authentication
	 * @param  array
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($mail, $password) = $credentials;

		$user = $this->userService->getFinder()->whereMail($mail)->whereActive()->getSingleResult();

		if ($user) {
			if ($user->verifyPassword($password)) {
				return new Identity($user->getId(), $user->getRole(), array(
					"name" => $user->getName(),
					"mail" => $user->getMail(),
				));
			} else {
				throw new AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
			}
		}

		throw new AuthenticationException("User not found.", self::IDENTITY_NOT_FOUND);
	}

}

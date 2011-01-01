<?php

namespace KladnoMinule\Model\User;

use Nette\Templates\FileTemplate;
use Nette\Templates\LatteFilter;
use Nette\Mail\Mail;

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



	public function sendLostPassword($user)
	{
		$user->setNewHash();

		$template = $this->createTemplate(__DIR__ . '/mail/lostPassword.phtml');
		$presenter = \Nette\Environment::getApplication()->getPresenter();
		$template->link = $presenter->link('//:Front:User:confirmLostPassword', array(
			'id' => $user->getId(),
			'hash' => $user->getHash(),
		));

		$mail = new Mail;
		$mail->setHtmlBody($template);
		$mail->setFrom('no-reply@kladnominule.cz', 'Kladno minulé');
		$mail->addTo($user->getMail(), $user->getName());
		$mail->send();

		$this->getEntityManager()->flush();
	}



	public function register($data)
	{
		$em = $this->getEntityManager();

		$user = new User($data);
		$em->persist($user);

		$template = $this->createTemplate(__DIR__ . '/mail/register.phtml');
		$presenter = \Nette\Environment::getApplication()->getPresenter();
		$template->link = $presenter->link('//:Front:User:finishRegistration', array(
			'hash' => $user->getHash(),
		));

		$em->flush();

		$mail = new Mail;
		$mail->setHtmlBody($template);
		$mail->setFrom('no-reply@kladnominule.cz', 'Kladno minulé');
		$mail->addTo($user->getMail(), $user->getName());
		$mail->send();
	}



	public function activateUser($hash)
	{
		$user = $this->getFinder()->whereHash($hash)->getSingleResult();

		if (!$user) {
			throw new UserNotFoundException("User with hash $hash cannot be found.");
		}

		$user->setActive(true);
		$this->getEntityManager()->flush();

		return $user;
	}



	protected function createTemplate($file)
	{
		$template = new FileTemplate;
		$template->setFile($file);
		$template->registerFilter(new LatteFilter);
		return $template;
	}

}
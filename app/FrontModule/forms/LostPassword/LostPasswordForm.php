<?php

namespace KladnoMinule\Form;

/**
 * Lost password form
 *
 * @author Jan Marek
 */
class LostPasswordForm extends \Neuron\Form\BaseForm
{
	protected function addFields()
	{
		$this->addText('mail')
			->setRequired('Vyplňte e-mail.');
	}



	protected function handler($values)
	{
		$service = $this->getService('UserService');
		$user = $service->findOneByMail($values['mail']);

		if ($user) {
			$service->sendLostPassword($user);
			$this->presenter->flashMessage('Byl vám poslán e-mail s novým heslem.');
			$this->presenter->redirect('User:lostPasswordSent');
		} else {
			$this->addError('Registrovaný uživatel s tímto e-mailem neexistuje.');
		}
	}

}
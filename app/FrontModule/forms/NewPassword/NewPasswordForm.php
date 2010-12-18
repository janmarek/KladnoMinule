<?php

namespace KladnoMinule\Form;

/**
 * New password form
 *
 * @author Jan Marek
 */
class NewPasswordForm extends \Neuron\Form\BaseForm
{
	protected function addFields()
	{
		$this->addHidden('mail');
		$this->addHidden('hash');
		$this->addPassword('password')->setRequired('Vyplňte heslo.');
		$this->addPassword('password2')
			->setRequired('Vyplňte heslo pro kontrolu ještě jednou.')
			->addRule(self::EQUAL, 'Vyplňte hesla stejně.', $this['password']);
	}



	protected function handler($values)
	{
		$service = $this->getService('UserService');
		$user = $service->findOneByMail($values['mail']);

		if ($user->verifyHash($values['hash'])) {
			$service->update($user, array(
				'password' => $values['password'],
			));
			$this->getUser()->login($values['mail'], $values['password']);

			$this->presenter->flashMessage('Nové heslo vám bylo úspěšně nastaveno.');
			$this->presenter->redirect('Homepage:');
		} else {
			throw new \Neuron\Model\ValidationException('Nezdařilo se nastavit heslo.');
		}
	}

}
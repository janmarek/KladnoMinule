<?php

namespace KladnoMinule\Form;

use Nette\Mail\Mail;

/**
 * Send mail form
 *
 * @author Jan Marek
 */
class SendMailForm extends \Neuron\Form\BaseForm
{
	private $from, $fromName, $to;



	protected function addFields()
	{
		$this->addText('subject');
		$this->addTextArea('text')->setRequired('Vyplňte text.');
	}



	protected function handler($values)
	{
		$mail = new Mail;
		$mail->setSubject($values['subject'] . ' (mail z webu Kladno minulé)');
		$mail->setBody($values['text']);
		$mail->addTo($this->to);
		$mail->setFrom($this->from, $this->fromName);
		$mail->send();
	}



	public function setFrom($from, $name = null)
	{
		$this->from = $from;
		$this->fromName = $name;
	}



	public function setTo($to)
	{
		$this->to = $to;
	}

}
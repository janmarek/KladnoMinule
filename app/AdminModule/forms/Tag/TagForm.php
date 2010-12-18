<?php

namespace KladnoMinule\Form;

/**
 * Tag form
 *
 * @author Jan Marek
 */
class TagForm extends \Neuron\Form\EntityForm
{
	protected function addFields()
	{
		$this->addText("name");
	}
}
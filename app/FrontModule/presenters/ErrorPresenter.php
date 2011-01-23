<?php

namespace KladnoMinule\Presenter\FrontModule;

use Nette\Debug, Nette\Application\BadRequestException;

/**
 * Error presenter
 */
class ErrorPresenter extends FrontPresenter
{

	/**
	 * @param  Exception
	 * @return void
	 */
	public function renderDefault($exception)
	{
		if ($this->isAjax()) { // AJAX request? Just note this error in payload.
			$this->payload->error = TRUE;
			$this->terminate();

		} elseif ($exception instanceof BadRequestException) {
			$code = $exception->getCode();
			$this->setView(in_array($code, array(403, 404, 405, 410, 500)) ? $code : '4xx'); // load template 403.phtml or 404.phtml or ... 4xx.phtml

		} else {
			$this->setView('500'); // load template 500.phtml
			Debug::log($exception); // and log exception
		}
	}

}

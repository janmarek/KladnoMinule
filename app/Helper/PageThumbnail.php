<?php

namespace KladnoMinule\Helper;

/**
 * PageThumbnail
 *
 * @author Jan Marek
 */
class PageThumbnail
{
	public static function getImage($page)
	{
		$url = \Nette\Environment::getService("PageService")->getPageThumbnailUrl($page);

		if (!$url) {
			return;
		}

		return \Nette\Web\Html::el("img")->alt("")->width(92)->height(92)->src($url)->class("gallery-thumb");
	}
}

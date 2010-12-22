<?php

namespace KladnoMinule\Model\Page;

/**
 * Page service
 *
 * @author Jan Marek
 */
class Service extends \Neuron\Model\Page\Service
{
	private $categoryService;

	private $userService;

	private $tagService;



	public function __construct($em, $categoryService, $userService, $tagService)
	{
		parent::__construct($em, __NAMESPACE__ . "\Page");
		$this->categoryService = $categoryService;
		$this->userService = $userService;
		$this->tagService = $tagService;
	}



	public function getFinder()
	{
		return new Finder($this);
	}



	public function getPublishedArticles()
	{
		return $this->getFinder()->whereAllowed()->orderByDateDesc();
	}



	public function addGallery($page)
	{
		$page->addPhotogallery();
		$this->getEntityManager()->flush();
	}



	public function setData($entity, $data)
	{
		if (isset($data['category'])) {
			$data['category'] = $this->categoryService->find($data['category']);
		}

		if (isset($data['author'])) {
			$data['author'] = $this->userService->find($data['author']);
		}

		if (isset($data['tags'])) {
			$tagService = $this->tagService;
			$data['tags'] = array_map(function ($id) use ($tagService) {
				return $tagService->find($id);
			}, $data['tags']);
		}

		parent::setData($entity, $data);
	}



	/**
	 * @return array
	 */
	public function getUrlDictionary()
	{
		$qb = $this->getPublishedArticles()->getQueryBuilder();
		$qb->select('partial p.{id, url}, partial c.{id, url}');
		$res = $qb->getQuery()->getScalarResult();

		$arr = array();

		foreach ($res as $item) {
			$arr[$item['p_id']] = ($item['c_url'] ? $item['c_url'] . '/' : '') . $item['p_url'];
		}

		return $arr;
	}

}
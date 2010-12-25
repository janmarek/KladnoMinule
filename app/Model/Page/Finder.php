<?php

namespace KladnoMinule\Model\Page;

/**
 * Page finder
 *
 * @author Jan Marek
 */
class Finder extends \Neuron\Model\Page\Finder
{
	public function __construct($service)
	{
		parent::__construct($service);
		$this->qb->leftJoin("p.author", "a");
		$this->qb->leftJoin("p.category", "c");
	}



	public function orderByDateDesc()
	{
		$this->qb->orderBy("p.created", "desc");
		return $this;
	}



	public function whereCategory($category)
	{
		$this->qb->andWhere("c.id = :catid")->setParameter("catid", $category->getId());
		return $this;
	}



	public function whereAuthor($author)
	{
		$this->qb->andWhere('p.author = :authorid')->setParameter('authorid', $author->getId());
		return $this;
	}



	public function whereTag($tag)
	{
		$this->qb->andWhere(':tagid member of p.tags')->setParameter('tagid', $tag->getId());
		return $this;
	}



	public function getQueryBuilder()
	{
		return $this->qb;
	}

}
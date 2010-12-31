<?php

namespace KladnoMinule\Model\Page;

use Nette\Image;

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


	public function getPublishedArticleById($id)
	{
		return $this->getPublishedArticles()->whereId($id)->getSingleResult();
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


	/**
	 * @return Nette\Image
	 */
	public function drawThumbnail($page)
	{
		$galleries = $page->getPhotoGalleries();

		$thumbPhotos = array();

		foreach ($galleries as $gallery) {
			foreach ($gallery->getPhotos() as $photo) {
				$thumbPhotos[] = $photo;
				if (count($thumbPhotos) > 2) {
					break;
				}
			}
			if (count($thumbPhotos) > 2) {
				break;
			}
		}

		$photoService = \Nette\Environment::getService("PhotoService");
		$thumbImages = array_map(function ($photo) use ($photoService) {
			return Image::fromFile($photoService->getImagePath($photo));
		}, $thumbPhotos);

		$size = 92;
		$thumb = Image::fromBlank($size, $size, Image::rgb(0, 0, 0));

		if (count($thumbImages) > 0) {
			$mainImage = array_shift($thumbImages);

			if (count($thumbImages) === 0) {
				$mainImage->resize($size - 4, $size - 4, Image::FILL)->crop("25%", "50%", $size - 4, $size - 4);
				$thumb->place($mainImage, 2, 2);
			} else {
				$horizontal = $mainImage->getWidth() > $mainImage->getHeight();

				$thumbImageSize = $size - 4;
				$thumbImageHalfSize = $size / 2 - 3;

				$mainImage->resize(
					$horizontal ? $thumbImageSize : $thumbImageHalfSize,
					$horizontal ? $thumbImageHalfSize : $thumbImageSize,
					Image::FILL
				)->crop(
					"25%", "50%",
					$horizontal ? $thumbImageSize : $thumbImageHalfSize,
					$horizontal ? $thumbImageHalfSize : $thumbImageSize
				);

				$thumb->place($mainImage, 2, 2);

				$smallImagesCount = count($thumbImages);

				$dim2 = $thumbImageHalfSize;
				$dim1 = $smallImagesCount === 1 ? $thumbImageSize : $thumbImageHalfSize;

				$smallThumb1 = $thumbImages[0]->resize($horizontal ? $dim1 : $dim2, $horizontal ? $dim2 : $dim1, Image::FILL)
					->crop("50%", "25%", $horizontal ? $dim1 : $dim2, $horizontal ? $dim2 : $dim1);

				$thumb->place($smallThumb1, $horizontal ? 2 : $size / 2 + 1, $horizontal ? $size / 2 + 1 : 2);

				if ($smallImagesCount === 2) {
					$smallThumb2 = $thumbImages[1]
						->resize($thumbImageHalfSize, $thumbImageHalfSize, Image::FILL)
						->crop("50%", "25%", $thumbImageHalfSize, $thumbImageHalfSize);
					$thumb->place($smallThumb2, $size / 2 + 1, $size / 2 + 1);
				}
			}
		}

		return $thumb;
	}



	public function getPageThumbnailUrl($page)
	{
		if (count($page->getPhotogalleries()) === 0) {
			return null;
		}

		$thumbPath = WWW_DIR . "/data/pagethumbs/" . $page->getId() . ".jpg";
		$thumbUrl = \Nette\Environment::getVariable("baseUri") . "data/pagethumbs/" . $page->getId() . ".jpg";

		if (!file_exists($thumbPath)) {
			$thumb = $this->drawThumbnail($page);

			if (!file_exists($thumbPath)) {
				$thumb->save($thumbPath);
			}
		}

		return $thumbUrl;
	}

}
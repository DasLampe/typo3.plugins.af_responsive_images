<?php
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Andre Flemming <daslampe@lano-crew.org>
 *
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is
 *  open source software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace DasLampe\AfResponsiveImages\ViewHelper;


use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class ImageViewHelper extends AbstractTagBasedViewHelper
{
    private $imageWidth;
    private $imageHeight;
    /**
     * @var TYPO3\CMS\Core\Resource\File
     */
    protected $file;

    /**
     * @var string
     */
    protected $alt;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var TYPO3\CMS\Extbase\Service\ImageService
     * @inject
     */
    protected $imageService;

    /**
     * @param File $image
     * @param array $srcSet
     * @param int $width
     * @param string $alt
     * @param string $title
     * @return string
     */
    public function render(
        File $image,
        array $srcSet = array('320' => '320', '480' => '480', '600' => '600', '800' => '800'),
        $width = 0,
        $alt = '',
        $title = ''
    ) {
        $this->setFile($image);
        $this->setAlt($alt);
        $this->setTitle($title);

        list($imageWidth, $imageHeight) = getimagesize(PATH_site. $this->file->getPublicUrl());

        $this->imageWidth = $imageWidth;
        $this->imageHeight = $imageHeight;

        return $this->getImgTag($this->getSrcSet($srcSet));
    }

    /**
     * @return string
     */
    protected function getImgTag(array $responsiveImages) {
        $this->tag->setTagName('img');
        $this->tag->addAttribute('src', $this->getFile()->getPublicUrl());
        $this->tag->addAttribute('srcset', implode(', /', $responsiveImages));
        $this->tag->addAttribute('title', $this->getTitle());
        $this->tag->addAttribute('alt', $this->getAlt());

        return $this->tag->render();
    }

    protected function getSrcSet(array $srcSet) {
        foreach($this->renderResponsiveImages($srcSet) as $viewport => $url) {
            $srcSets[] = $url.' '.$viewport.'w';
        }

        return $srcSets;
    }

    protected function renderResponsiveImages(array $srcSet) {
        $processedFiles = array();

        foreach($srcSet as $viewPort => $width) {
            $processedFiles[$viewPort] = $this->imageService->applyProcessingInstructions(
                $this->file,
                $this->getProcessInstruction($width)
            )->getPublicUrl();
        }
        return $processedFiles;
    }

    /**
     * @param $width
     * @return array
     */
    protected function getProcessInstruction($width) {
        return [
            'width' => null,
            'height' => null,
            'minWidth' => null,
            'minHeight' => null,
            'maxWidth' => $width,
            'maxHeight' => null,
            'crop' => null,
        ];
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
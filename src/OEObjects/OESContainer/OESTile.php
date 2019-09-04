<?php
/**
 * Created by PhpStorm.
 * User: main
 * Date: 02/09/17
 * Time: 14:26
 */

namespace MetroUI_GET\OEObjects\OESContainer;

use GotTemplateExtension\OEObjects\OESContainer;
use GraphicObjectTemplating\OObjects\ODContained\ODBadge;
use GraphicObjectTemplating\OObjects\ODContained\ODImage;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

/**
 * Class OESTile
 * @package MetroUIThemeGOT\OEObject
 *
 * setSize($size)           :
 * getSize()                :
 * setSizeX($sizeX)         :
 * getSizeX()               :
 * setSizeY($sizeY)         :
 * getSizeY()               :
 * setAspect($aspect)       :
 * getAspect()              :
 * setLabel                 : affectation du texte présenté dans la tuile
 * getLabel                 : récupération du texte présenté dans la tuile
 * enaBadge                 :
 * disBadge                 :
 * setIconName($iconName)   :
 * getIconName()            :
 * setBgColor($bgColor)     :
 * getBgColor()             :
 * setFgColor($FgColor)     :
 * getFgColor()             :
 * evtClick($class, $method, $stopEvent = true)
 * disClick()
 */

class OESTile extends OESContainer
{
    const SIZE_SMALL    = 'tile-small';     // (70x70)
    const SIZE_LITTLE   = 'tile-little';    // (100x100)
    const SIZE_NORMAL   = 'tile-square';    // (150x150)
    const SIZE_WIDE     = 'tile-wide';      // (310x150)
    const SIZE_LARGE    = 'tile-large';     // (310x310)
    const SIZE_BIG      = 'tile-big';       // (470x470)
    const SIZE_SUPER    = 'tile-super';     // (630x630)
    const SIZE_CUSTOM   = 'tile-custom';    // (XxY) => voir sizeX zt sizeY

    const SIZEX_SMALL   = 'tile-small-x';   // 70
    const SIZEX_NORMAL  = 'tile-square-x';  // 150
    const SIZEX_WIDE    = 'tile-wide-x';    // 310
    const SIZEX_BIG     = 'tile-big-x';     // 470
    const SIZEX_SUPER   = 'tile-super-x';   // 630

    const SIZEY_SMALL   = 'tile-small-y';   // 70
    const SIZEY_NORMAL  = 'tile-square-y';  // 150
    const SIZEY_WIDE    = 'tile-wide-y';    // 310
    const SIZEY_BIG     = 'tile-big-y';     // 470
    const SIZEY_SUPER   = 'tile-super-y';   // 630

    const ASPECT_ICONIC     = 'iconic';
    const ASPECT_OBJECT     = 'object';
    const ASPECT_IMAGESET   = 'imageset';
    const ASPECT_CAROUSEL   = 'carousel';

    private $const_size;
    private $const_sizeX;
    private $const_sizeY;
    private $const_aspect;

    public function __construct($id, $build = false, $aspect = null)
    {
        $oeopath[]  = __DIR__ . "/../../../view/zf3-graphic-object-templating/oeobjects/oescontainer/oestile/oestile.config.php";
        $oopath[]   = "oobjects/odcontained/odcontained.config.php";
        parent::__construct($id, $oeopath, $oopath);
        $this->setClassName(self::class);

        if ($build) {
            $badge = new ODBadge($id.'_badge');
            $this->addChild($badge);
        }

        if (!empty($aspect)) { $this->setAspect($aspect); }
        $this->enable();
        $this->saveProperties();
        return $this;
    }

    public function setSize($size)
    {
        $size = (string) $size;
        $sizes = $this->getSizeConst();
        if (!in_array($size, $sizes, true)) { $size = self::SIZE_NORMAL; }
        $properties = $this->getProperties();
        $properties['size'] = $size;
        switch ($size) {
            case self::SIZE_SMALL:
                $properties['sizeX'] = self::SIZEX_SMALL;
                $properties['sizeY'] = self::SIZEY_SMALL;
                break;
            case self::SIZE_NORMAL:
                $properties['sizeX'] = self::SIZEX_NORMAL;
                $properties['sizeY'] = self::SIZEY_NORMAL;
                break;
            case self::SIZE_WIDE:
                $properties['sizeX'] = self::SIZEX_WIDE;
                $properties['sizeY'] = self::SIZEY_NORMAL;
                break;
            case self::SIZE_LARGE:
                $properties['sizeX'] = self::SIZEX_WIDE;
                $properties['sizeY'] = self::SIZEY_WIDE;
                break;
            case self::SIZE_BIG:
                $properties['sizeX'] = self::SIZEX_BIG;
                $properties['sizeY'] = self::SIZEY_BIG;
                break;
            case self::SIZE_SUPER:
                $properties['sizeX'] = self::SIZEX_SUPER;
                $properties['sizeY'] = self::SIZEY_SUPER;
                break;
        }
        $this->setProperties($properties);
        return $this;
    }

    public function getSize()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['size'])) ? $properties['size'] : false);
    }

    public function setSizeX($sizeX)
    {
        $sizeX  = (string) $sizeX;
        $sizeXs = $this->getSizeXConst();
        if (!in_array($sizeX, $sizeXs, true)) { $sizeX = self::SIZEX_NORMAL; }
        $properties = $this->getProperties();
        $properties['sizeX'] = $sizeX;
        $sizeY = $properties['sizeY'];
        $this->setProperties($properties);
        switch (true) {
            case ($sizeX == self::SIZEX_SMALL && $sizeY == self::SIZEY_SMALL) :
                $this->setSize(self::SIZE_SMALL);
                break;
            case ($sizeX == self::SIZEX_NORMAL && $sizeY == self::SIZEY_NORMAL) :
                $this->setSize(self::SIZE_NORMAL);
                break;
            case ($sizeX == self::SIZEX_WIDE && $sizeY == self::SIZEY_NORMAL) :
                $this->setSize(self::SIZE_WIDE);
                break;
            case ($sizeX == self::SIZEX_WIDE && $sizeY == self::SIZEY_WIDE) :
                $this->setSize(self::SIZE_LARGE);
                break;
            case ($sizeX == self::SIZEX_BIG && $sizeY == self::SIZEY_BIG) :
                $this->setSize(self::SIZE_BIG);
                break;
            case ($sizeX == self::SIZEX_SUPER && $sizeY == self::SIZEY_SUPER) :
                $this->setSize(self::SIZE_SUPER);
                break;
            default:
                $this->setSize(self::SIZE_CUSTOM);
                break;
        }
        return $this;
    }

    public function getSizeX()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['sizeX'])) ? $properties['sizeX'] : false);
    }

    public function setSizeY($sizeY)
    {
        $sizeY  = (string) $sizeY;
        $sizeYs = $this->getSizeYConst();
        if (!in_array($sizeY, $sizeYs, true)) { $sizeY = self::SIZEY_NORMAL; }
        $properties = $this->getProperties();
        $properties['sizeY'] = $sizeY;
        $sizeX = $properties['sizeX'];
        $this->setProperties($properties);
        switch (true) {
            case ($sizeX == self::SIZEX_SMALL && $sizeY == self::SIZEY_SMALL) :
                $this->setSize(self::SIZE_SMALL);
                break;
            case ($sizeX == self::SIZEX_NORMAL && $sizeY == self::SIZEY_NORMAL) :
                $this->setSize(self::SIZE_NORMAL);
                break;
            case ($sizeX == self::SIZEX_WIDE && $sizeY == self::SIZEY_NORMAL) :
                $this->setSize(self::SIZE_WIDE);
                break;
            case ($sizeX == self::SIZEX_WIDE && $sizeY == self::SIZEY_WIDE) :
                $this->setSize(self::SIZE_LARGE);
                break;
            case ($sizeX == self::SIZEX_BIG && $sizeY == self::SIZEY_BIG) :
                $this->setSize(self::SIZE_BIG);
                break;
            case ($sizeX == self::SIZEX_SUPER && $sizeY == self::SIZEY_SUPER) :
                $this->setSize(self::SIZE_SUPER);
                break;
            default:
                $this->setSize(self::SIZE_CUSTOM);
                break;
        }
        return $this;
    }

    public function getSizeY()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['sizeY'])) ? $properties['sizeY'] : false);
    }

    public function setAspect($aspect)
    {
        $aspect  = (string) $aspect;
        $aspects = $this->getAspectConst();
        if (!in_array($aspect, $aspects, true)) { $aspect = self::ASPECT_ICONIC; }
        $properties = $this->getProperties();
        $properties['aspect'] = $aspect;
        $this->setProperties($properties);

        // suppression de tous les objets existant sauf ODBadge
        $children = $this->getChildren();
        foreach ($children as $child) {
            if (!($child instanceof ODBadge)) {
                $this->removeChild($child);
            }
        }
        switch ($aspect) {
            case self::ASPECT_ICONIC:
                break;
            case self::ASPECT_OBJECT:
                break;
            case self::ASPECT_IMAGESET:
                // ajout de l'objet OESImageSet
                $imageSet = new OESImageSet($this->getId().'_imageSet');
                if (OObject::existObject($this->getId().'_badge')) {
                    $this->addChild($imageSet, OSContainer::MODE_BEFORE, $this->getId().'_badge');
                } else {
                    $this->addChild($imageSet, OSContainer::MODE_FIRST);
                }
                break;
            case self::ASPECT_CAROUSEL:
                break;
        }
        return $this;
    }

    public function getAspect()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['aspect'])) ? $properties['aspect'] : false);
    }

    public function setLabel($label)
    {
        $label               = (string) $label;
        $properties          = $this->getProperties();
        $properties['label'] = $label;
        $this->setProperties($properties);
        return $this;
    }

    public function getLabel()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['label'])) ? $properties['label'] : false) ;
    }

    public function enaBadge()
    {
        $children   = $this->getChildren();
        $notfound   = true;
        foreach ($children as $child) {
            if ($child instanceof ODBadge) {
                $child->setDisplay(OObject::DISPLAY_BLOCK);
                $child->saveProperties();
                $notfound   = false;
            }
        }
        if ($notfound) {
            $badge = new ODBadge($this->getId().'_badge');
            $badge->setDisplay(OObject::DISPLAY_BLOCK);
            $badge->saveProperties();
            $this->addChild($badge);
//            $this->setAspect(self::ASPECT_ICONIC );
            $this->enable();
        }

        $properties = $this->getProperties();
        $properties['badge'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disBadge()
    {
        $properties = $this->getProperties();
        $properties['badge'] = false;

        $children = $this->getChildren();
        foreach ($children as $child) {
            if ($child instanceof ODBadge) { $child->setDisplay(OObject::DISPLAY_NONE); }
        }

        $this->setProperties($properties);
        return $this;
    }

    public function getBadge()
    {
        $children = $this->getChildren();
        foreach ($children as $child) {
            if ($child instanceof ODBadge) { return $child; }
        }
    }

    public function setIconName($iconName)
    {
        $iconName = (string) $iconName;
        $properties = $this->getProperties();
        $properties['iconName'] = $iconName;
        $this->setProperties($properties);
        return $this;
    }

    public function getIconName()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['iconName'])) ? $properties['iconName'] : false) ;
    }

    public function setBgColor($bgColor)
    {
        $bgColor  = (string) $bgColor;
        $bgColors = $this->getColorConstants();
        if (!in_array($bgColor, $bgColors, true)) { $bgColor = 'bg-'.self::COLOR_GRAYLIGHTER; }
        else                                            { $bgColor = 'bg-'.$bgColor; }
        $properties = $this->getProperties();
        $properties['bgcolor'] = $bgColor;
        $this->setProperties($properties);
        return $this;
    }

    public function getBgColor()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['bgcolor'])) ? $properties['bgcolor'] : false);
    }

    public function setFgColor($fgColor)
    {
        $fgColor  = (string) $fgColor;
        $fgColors = $this->getColorConstants();
        if (!in_array($fgColor, $fgColors, true)) { $fgColor = 'fg-'.self::COLOR_BLACK; }
        else                                            { $fgColor = 'fg-'.$fgColor; }
        $properties = $this->getProperties();
        $properties['fgcolor'] = $fgColor;
        $this->setProperties($properties);
        return $this;
    }

    public function getFgColor()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['fgcolor'])) ? $properties['fgcolor'] : false);
    }

    public function evtClick($class, $method, $stopEvent = true)
    {
        $class = (string)$class;
        $method = (string)$method;
        $properties = $this->getProperties();
        if (!isset($properties['event'])) {
            $properties['event'] = [];
        }
        if (!is_array($properties['event'])) {
            $properties['event'] = [];
        }

        $properties['event']['click'] = [];
        $properties['event']['click']['class'] = $class;
        $properties['event']['click']['method'] = $method;
        $properties['event']['click']['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';

        $this->setProperties($properties);
        return $this;
    }

    public function disClick()
    {
        $properties = $this->getProperties();
        if (isset($properties['event']['click'])) {
            unset($properties['event']['click']);
        }
        $this->setProperties($properties);
        return $this;
    }

    /** méthode pour tile imageSet raccorcie poyur l'objet inclus OESImageSet */
    public function addImage($nom, ODImage $image)
    {
        switch ($this->getAspect()) {
            case self::ASPECT_IMAGESET:
                $idImgSet   = $this->getId().'_imageSet';
                $ret = $this->$idImgSet->addImage($nom, $image);
                break;
            case self::ASPECT_CAROUSEL:
                $image->setName($nom);
                $image->setClasses('slide');
                $image->addStyle('display:none;');
                $this->addChild($image, OSContainer::MODE_BEFORE, $this->getId().'_badge');
                $ret = $this;
                break;
        }
        return $ret;
    }

    public function setImages(array $images)
    {
        switch ($this->getAspect()) {
            case self::ASPECT_IMAGESET:
                $idImgSet   = $this->getId().'_imageSet';
                $ret = $this->$idImgSet->setImages($images);
                break;
            case self::ASPECT_CAROUSEL:
                foreach ($images as $nom => $image) {
                    $image->setName($nom);
                    $image->addClass('slide');
                    $image->addStyle('display:none;');
                    $this->addChild($image);
                }
                $ret = $this;
                break;
        }
        return $ret;
    }

    public function setImage($nom, ODImage $image)
    {
        $nom        = (string) $nom;
        switch ($this->getAspect()) {
            case self::ASPECT_IMAGESET:
                $idImgSet   = $this->getId().'_imageSet';
                $ret = $this->$idImgSet->setImages($images);
                break;
            case self::ASPECT_CAROUSEL:
                $properties = $this->getProperties();
                $children   = $this->getChildren();
                foreach ($children as $key => $child) {
                    if ($nom == $child->getName()) {
                        $properties['children'][$key] = $image;
                    }
                }
                $ret = $this;
                break;
        }
        return $ret;
    }

    public function getImages()
    {
        switch ($this->getAspect()) {
            case self::ASPECT_IMAGESET:
                $idImgSet   = $this->getId().'_imageSet';
                $properties = $this->$idImgSet->getProperties();
                break;
            case self::ASPECT_CAROUSEL:
                $properties = $this->getProperties();
                break;
        }
        return ((!empty($properties['images'])) ? $properties['images'] : false);
    }

    public function getImage($nom)
    {
        $nom        = (string) $nom;
        switch ($this->getAspect()) {
            case self::ASPECT_IMAGESET:
                $idImgSet = $this->getId().'_imageSet';
                $children = $this->$idImgSet->getChildren();
                break;
            case self::ASPECT_CAROUSEL:
                $children = $this->getChildren();
                break;
        }
        /** @var ODImage $image */
        foreach ($children as $child) {
            if ($nom == $child->getName()) {
                return $child;
            }
        }
        return false;
    }


    private function getSizeConst()
    {
        $retour = [];
        if (empty($this->const_size)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'SIZE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_size = $retour;
        } else {
            $retour = $this->const_size;
        }
        return $retour;
    }

    private function getSizeXConst()
    {
        $retour = [];
        if (empty($this->const_sizeX)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'SIZEX');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_sizeX = $retour;
        } else {
            $retour = $this->const_sizeX;
        }
        return $retour;
    }

    private function getSizeYConst()
    {
        $retour = [];
        if (empty($this->const_sizeY)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'SIZEY');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_sizeY = $retour;
        } else {
            $retour = $this->const_sizeY;
        }
        return $retour;
    }

    private function getAspectConst()
    {
        $retour = [];
        if (empty($this->const_aspect)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ASPECT');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_aspect = $retour;
        } else {
            $retour = $this->const_aspect;
        }
        return $retour;
    }
}
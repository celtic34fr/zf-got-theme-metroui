<?php

namespace MetroUI_GET\OEObjects\OESContainer;

use GotTemplateExtension\OEObjects\OESContainer;

/**
 * Class OESTileGroup
 * @package Application\GotExtension\OEObject\OESContainer
 *
 * setLarage($large)
 * getLarge()
 * setTitle($title)
 * getTitle
 */
class OESTileGroup extends OESContainer
{
    const LARGE_ONE     = 'one';
    const LARGE_TWO     = 'two';
    const LARGE_THREE   = 'three';
    const LARGE_FOUR    = 'four';
    const LARGE_FIVE    = 'five';
    const LARGE_SIX     = 'six';
    const LARGE_SEVEN   = 'seven';

    private $const_large;

    public function __construct($id)
    {
        $pathConfig = __DIR__ . "/../../../view/graphic-object-templating/oeobjects/oescontainer/oestilegroup/oestilegroup.config.php";
        parent::__construct($id,$pathConfig , OESTileGroup::class);
        $this->enable();
        return $this;
    }

    public function setLarge($large)
    {
        $large  = (string) $large;
        $larges = $this->getLargeConst();
        if (!in_array($large, $larges, true)) { $large = self::LARGE_TWO; }
        $properties = $this->getProperties();
        $properties['large'] = $large;
        $this->setProperties($properties);
        return $this;
    }

    public function getLarge()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['large'])) ? $properties['large'] : false);
    }

    public function setTitle($title = "")
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitle()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('title', $properties)) ? $properties['title'] : false ;
    }


    private function getLargeConst()
    {
        $retour = [];
        if (empty($this->const_large)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'LARGE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_large = $retour;
        } else {
            $retour = $this->const_large;
        }
        return $retour;
    }
}
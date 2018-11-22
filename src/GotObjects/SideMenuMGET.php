<?php

namespace MetroUI_GET\GotObjects;

use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSDiv;
use MetroUI_GET\OEObjects\OESContainer\OESTile;

class SideMenuMGET extends OSDiv
{
    /** @var  OESTile $sideOestile */
    private $sideOestile;

    public function __construct()
    {
        parent::__construct('SideMenuMGET');
        $this->setClassName(self::class);
    }

    public function init()
    {
        $this->sideOestile = new OESTile('sideOestile', false);

        $this->sideOestile->setDisplay(self::DISPLAY_NONE);
        $this->sideOestile->saveProperties();

        $this->addChild($this->sideOestile);
        $this->addClass('fg-white tile-area-scheme-dark');
        $this->addCodeCss('#SideMenuMGET', 'height: 100%;width:calc(100% - 0.6em);padding-top:0.6em;padding-bottom:0.6em;');
        $this->addCodeCss('#SideMenuMGET div[data-role="tile"]', 'margin-left: 0.2rem;');
        $this->saveProperties();

    }

    public function addTile($id, $label, $size = OESTile::SIZE_NORMAL, $bgColor = 'bg-'.OObject::COLOR_WHITE, $fgColor = 'fg-'.OObject::COLOR_BLACK, $icons = null)
    {
        $sessionObject  = OObject::validateSession();
        /** @var OESTile $tile */
        $tile           = OObject::cloneObject($this->sideOestile, $sessionObject);

        $tile->setId($id);
        $tile->setName($id);
        $tile->setLabel($label);
        $tile->setSize($size);
        $tile->setBgColor($bgColor);
        $tile->setFgColor($fgColor);
        $tile->setIconName($icons);
        $tile->setDisplay(self::DISPLAY_BLOCK);
        $tile->saveProperties();

        $this->addChild($tile);
        $this->saveProperties();
    }

    public function clearTile()
    {
        $sessionObject  = OObject::validateSession();
        $properties     = $this->getProperties();
        $children       = $properties['children'];
        foreach ($children as $idChild => $valChild) {
            if ($idChild != 'oestile') {
                unset($children[$idChild]);
                if (!OObject::oyObject($idChild, false)) {
                    throw new \Exception("uction de l'objet ".$idChild." impossible" );
                }
            }
        }
        $properties['children'] = $children;
        $this->setProperties($properties);
        $this->saveProperties();
    }
}
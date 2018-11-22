<?php

namespace MetroUI_GET\GotObjects;

use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\ODContained\ODSpan;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSDiv;
use MetroUI_GET\OEObjects\OEObject;
use MetroUI_GET\OEObjects\OESContainer\OESTile;

class PageMGET extends OSDiv
{
    /** @var HeaderMenuMGET $headerMenuMGET */
    protected $headerMenuMGET;
    /** @var SideMenuMGET $sideMenuMGET */
    protected $sideMenuMGET;
    /** @var OSDiv $contentPMG */
    protected $contentPMG;
    /** @var ODSpan $footerPMG */
    protected $footerPMG;

    public function __construct($first = false)
    {
        if ($first) {
            OEObject::destroyObject('', true);
        }
        parent::__construct('PageMGET');
        $this->setClassName(self::class);
    }

    public function init()
    {
        $sessionObjects = OObject::validateSession();

        $this->headerMenuMGET   = OObject::buildObject('HeaderMenuMGET', $sessionObjects);
        $this->sideMenuMGET     = OObject::buildObject('SideMenuMGET', $sessionObjects);
        $this->contentPMG       = new OSDiv('contentPMG');
        $this->footerPMG        = new ODSpan('footerPMG');

        $this->headerMenuMGET->init();
        $this->headerMenuMGET->disableBtn();
        $this->headerMenuMGET->setWidthBT(12);
        $this->headerMenuMGET->setClasses('app-bar darcula');
        $this->headerMenuMGET->saveProperties();

        $this->sideMenuMGET   = OObject::buildObject('SideMenuMGET', $this->sessionObjects);
        $this->sideMenuMGET->removeChildren();
        $this->sideMenuMGET->init();
        $this->sideMenuMGET->addClass('cell');
        $properties = $this->sideMenuMGET->getProperties();
        $properties['widthBT'] = "";
        $this->sideMenuMGET->setProperties($properties);
        $this->sideMenuMGET->saveProperties();

        $this->contentPMG->setClasses('cell auto-size');
        $properties = $this->contentPMG->getProperties();
        $properties['widthBT'] = "";
        $this->contentPMG->setProperties($properties);
        $this->contentPMG->saveProperties();

        $this->footerPMG->setWidthBT(12);
        $this->footerPMG->setContent("<p>&copy; 2018 by Gamma7Production, All rights reserved.</p>");
        $this->footerPMG->saveProperties();

        $this->addChild($this->headerMenuMGET);
        $this->addChild($this->sideMenuMGET);
        $this->addChild($this->contentPMG);
        $this->addChild($this->footerPMG);
    }

    public function initHeader($title, $identity, array $btnEvts)
    {
        $this->headerMenuMGET->setTitleHMG($title);

        if ($identity) {
            $this->headerMenuMGET->enableBtn();
            foreach ($btnEvts as $btnEvt) {
                $sessionObjects = OObject::validateSession();
                /** @var ODButton $object */
                $object     = OObject::buildObject($btnEvt['id'], $sessionObjects);
                $rc         = $object->evtClick($btnEvt['class'], $btnEvt['method'], $btnEvt['stopEvent']);
                $object->saveProperties();
            }
        }

        $this->headerMenuMGET->saveProperties();
    }

    public function setTiles(array $tiles)
    {
        foreach ($tiles as $tile) {
            $this->sideMenuMGET->addTile(
                $tile['id'], $tile['label'], $tile['size'], $tile['bgColor'], $tile['fgColor'], $tile['icons']);
        }
        $this->sideMenuMGET->saveProperties();
    }

    public function evtClickTile($id, $class, $method, $stopEvent = true)
    {
        $sessionObjects = OObject::validateSession();
        $objects        = $sessionObjects->objects;
        if (array_key_exists($id, $objects)) {
            /** @var OESTile $object */
            $object     = OObject::buildObject($id, $this->sessionObjects);
            $rc         = $object->evtClick($class, $method, $stopEvent);
            $object->saveProperties();
            return $rc;
        }
        return false;
    }

}
<?php

namespace MetroUI_GET\Service;


use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\OObject;
use MetroUI_GET\GotObjects\HeaderMenuMGET;
use MetroUI_GET\GotObjects\SideMenuMGET;
use MetroUI_GET\OEObjects\OESContainer\OESTile;
use Zend\ServiceManager\ServiceManager;

class MetroUIServices
{
    /** @var ServiceManager $serviceManager */
    private $serviceManager;

    private $sessionObjects;

    public function __construct(ServiceManager $serviceManager, $sessionObjects)
    {
        $this->serviceManager   = $serviceManager;
        $this->sessionObjects   = $sessionObjects;
    }

    public function initPage($title, array $tiles, $identity = null, array $btnEvts)
    {
        /** @var HeaderMenuMGET $headerMenuMGET */
        $headerMenuMGET = OObject::buildObject('HeaderMenuMGET', $this->sessionObjects);
        $headerMenuMGET->init();
        $headerMenuMGET->setTitleHMG($title);
        $headerMenuMGET->disableBtn();

        /** @var SideMenuMGET $sideMenuMGET */
        $sideMenuMGET   = OObject::buildObject('SideMenuMGET', $this->sessionObjects);
        $sideMenuMGET->removeChildren();
        $sideMenuMGET->init();
        foreach ($tiles as $tile) {
            $sideMenuMGET->addTile(
                $tile['id'], $tile['label'], $tile['size'], $tile['bgColor'], $tile['fgColor'], $tile['icons']);
        }

        if ($identity) {
            $headerMenuMGET->enableBtn();
            $headerMenuMGET->displayNoneBtn();
            foreach ($btnEvts as $btnEvt) {
                $sessionObjects = OObject::validateSession();
                /** @var ODButton $object */
                $object     = OObject::buildObject($btnEvt['id'], $sessionObjects);
                $rc         = $object->evtClick($btnEvt['class'], $btnEvt['method'], $btnEvt['stopEvent']);
                if (array_key_exists('infoBulle', $btnEvt)&& !empty($btnEvt['infoBulle'])) {
                    $infoBulle  = $btnEvt['infoBulle'];
                    $posSepar   = strpos($infoBulle, ':');
                    $type       = substr($infoBulle, 0, $posSepar);
                    $texte      = substr($infoBulle, $posSepar + 1);
                    $object->setIBType($type);
                    $object->setIBContent($texte);
                    $object->setIBPlacement(OObject::IBPLACEMENT_BOTTOM);
                }
                $object->setDisplay(OObject::DISPLAY_BLOCK);
                $object->saveProperties();
            }
        }

        return [$headerMenuMGET, $sideMenuMGET];
    }

    public function evtClickTile($id, $class, $method, $stopEvent = true)
    {
        $objects = $this->sessionObjects->objects;
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
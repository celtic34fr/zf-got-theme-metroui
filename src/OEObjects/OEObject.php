<?php

namespace MetroUI_GET\OEObjects;

use GotTemplateExtension\OEObjects\OEObject as OEObjectBase;

class OEObject extends OEObjectBase
{
    public static function destroyObject($id, $session = false)
    {
        $now    = new \DateTime();
        $sessionObj = self::validateSession();
        $objects        = $sessionObj->objects;
        $headerMenuMGET = "";
        $sideMenuMGET   = "";

        if (array_key_exists('HeaderMenuMGET', $objects)) {
            $headerMenuMGET = $objects['HeaderMenuMGET'];
        }
        if (array_key_exists('SideMenuMGET', $objects)) {
            $sideMenuMGET = $objects['SideMenuMGET'];
        }

        if (parent::destroyObject($id, $session)) {
            $objects                    = $sessionObj->objects;
            $objects['HeaderMenuMGET']  = $headerMenuMGET;
            $objects['SideMenuMGET']    = $sideMenuMGET;
            $sessionObj->objects        = $objects;
            return true;
        }
        return false;
    }

}
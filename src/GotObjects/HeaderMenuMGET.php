<?php

namespace MetroUI_GET\GotObjects;

use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\ODContained\ODSpan;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSDiv;

class HeaderMenuMGET extends OSDiv
{
    /** @var  ODSpan $titleHMG */
    private $titleHMG;
    /** @var  OSDiv $tileAreaControlSAG */
    protected $tileAreaControlSAG;

    /** @var  ODButton $btnUserTAC */
    protected $btnUserTAC;
    /** @var  ODButton $btnLogoutTAC */
    protected $btnLogoutTAC;

    public function __construct()
    {
        parent::__construct('HeaderMenuMGET');
        $this->setClassName(self::class);
        $this->saveProperties();
        return $this;
    }

    public function init()
    {

        $this->titleHMG             = new ODSpan('titleHMG');
        $this->tileAreaControlSAG   = new OSDiv('tileAreaControlSAG');

        $this->btnUserTAC           = new ODButton('btnUserTAC');
        $this->btnLogoutTAC         = new ODButton('btnLogoutTAC');

        $this->titleHMG             -> setWidthBT(5);
        $this->titleHMG             -> addClass('float-left');
        $this->titleHMG             -> saveProperties();

        $this->tileAreaControlSAG   -> setWidthBT(5);
        $this->tileAreaControlSAG   -> addClass('float-right');
        $this->tileAreaControlSAG   -> saveProperties();

        $this->btnUserTAC->setClasses('float-right width-unset square-button icon-right bg-black fg-black bg-hover-dark no-border');
        $this->btnUserTAC->setWidthBT(0);
        $this->btnUserTAC->setIcon('fa fa-user icon');
        $this->btnUserTAC->setType(ODButton::BUTTONTYPE_CUSTOM);
        $this->btnUserTAC->saveProperties();

        $this->btnLogoutTAC->setClasses('float-right square-button bg-black fg-white bg-hover-dark no-border');
        $this->btnLogoutTAC->setWidthBT(1);
        $this->btnLogoutTAC->setIcon('fa fa-power-off');
        $this->btnLogoutTAC->evtClick(self::class, 'logout');
        $this->btnLogoutTAC->setType(ODButton::BUTTONTYPE_CUSTOM);
        $this->btnLogoutTAC->setNature(ODButton::BUTTONNATURE_DANGER);
        $this->btnLogoutTAC->saveProperties();

        $this->addChild($this->titleHMG);
        $this->addChild($this->tileAreaControlSAG);
        $this->addClass('fg-white tile-area-scheme-dark');
        $this->addCodeCss('#titleHMG h2','margin-top: 5px !important;');
        $this->saveProperties();

        $this->tileAreaControlSAG->addChild($this->btnLogoutTAC);
        $this->tileAreaControlSAG->addChild($this->btnUserTAC);
        $this->tileAreaControlSAG->saveProperties();
    }

    public function setTitleHMG($title)
    {
        $title = '<h2>' .(string) $title .'</h2>';
        $this->titleHMG->setContent($title);
        $this->titleHMG->saveProperties();
    }

    public function setUsernameHMG($username)
    {
        $username = (string) $username;
        $this->btnUserTAC->setLabel($username);
        $this->btnUserTAC->saveProperties();
    }

    public function disableBtn()
    {
        $sessionObject  = OObject::validateSession();
        /** @var ODButton $btnUserTAC */
        $btnUserTAC     = OObject::buildObject('btnUserTAC', $sessionObject);
        $btnUserTAC->disable();
        $btnUserTAC->saveProperties();
        /** @var ODButton $btnLogoutTAC */
        $btnLogoutTAC   = OObject::buildObject('btnLogoutTAC', $sessionObject);
        $btnLogoutTAC->disable();
        $btnLogoutTAC->saveProperties();
    }

    public function enableBtn()
    {
        $sessionObject  = OObject::validateSession();
        /** @var ODButton $btnUserTAC */
        $btnUserTAC     = OObject::buildObject('btnUserTAC', $sessionObject);
        $btnUserTAC->enable();
        $btnUserTAC->saveProperties();
        /** @var ODButton $btnLogoutTAC */
        $btnLogoutTAC   = OObject::buildObject('btnLogoutTAC', $sessionObject);
        $btnLogoutTAC->enable();
        $btnLogoutTAC->saveProperties();
    }

    public function evtClickBtn($id, $class, $method, $stopEvent = true)
    {
        if (!in_array($id, ['btnUserTAC', 'btnLogoutTAC'])) {
            throw new \Exception('unknown button id '.$id);
        }

        $sessionObjects = OObject::validateSession();
        /** @var ODButton $object */
        $object     = OObject::buildObject($id, $sessionObjects);
        $rc         = $object->evtClick($class, $method, $stopEvent);
        $object->saveProperties();
        return $rc;
    }
}
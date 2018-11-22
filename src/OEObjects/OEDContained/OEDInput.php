<?php

namespace MetroUI_GET\OEObjects\OEDContained;

use GotTemplateExtension\OEObjects\OEDContained;
use GraphicObjectTemplating\OObjects\ODContained\ODInput;

class OEDInput extends OEDContained
{
    public function __construct($id)
    {
        $oeopath    = __DIR__ .'/../../../view/zf3-graphic-object-templating/oeobjects/oedcontained/oedinput/oedinput.config.php';
        $oopath     = "oobjects/odcontained/odinput/odinput.config.php";
        parent::__construct($id, $oeopath, $oopath);
        $this->setClassName(self::class);

        if (!$this->getWidthBT() || empty($this->getWidthBT())) {
            $this->setWidthBT(12);
        }
        $this->setDisplay(self::DISPLAY_BLOCK);
        $this->enable();

        $this->setTExtendInstances(new ODInput($id));
        $this->saveProperties();
        return $this;
    }
}
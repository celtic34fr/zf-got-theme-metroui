<?php

use GraphicObjectTemplating\OObjects\OObject;
use MetroUI_GET\OEObjects\OESContainer\OESTile;

return [
    "extension" => true,
    "object"    => "oestile",
    "typeObj"   => "oescontainer",
    "template"  => "oestile.twig",
    "size"      => OESTile::SIZE_NORMAL,
    "sizeX"     => OESTile::SIZEX_NORMAL,
    "sizeY"     => OESTile::SIZEY_NORMAL,
    "aspect"    => OESTile::ASPECT_ICONIC,
    "label"     => "",
    "iconName"  => "fa fa-users",
    "bgcolor"   => "bg-".OObject::COLOR_GRAYLIGHTER,
    "fgcolor"   => "fg-".OObject::COLOR_BLACK,
    'badge'     => false,
    "images"    => [],
    "event"     => [],

    "resources" => [
        "prefix" => 'metroui/oeobjects/',
        "css"    => ['oestile.css' => 'css/oestile.css'],
        "js"     => ['oestile.js' => 'js/oestile.js'],
    ],
];
?>
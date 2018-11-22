<?php

use MetroUI_GET\OEObjects\OESContainer\OESTileGroup;

return [
    "extension"     => true,
    "object"    => "oestilegroup",
    "typeObj"   => "oescontainer",
    "template"  => "oestilegroup.twig",
    'large'     => OESTileGroup::LARGE_TWO,
    "event"     => [],

    "resources" => [
        "prefix" => 'gotextension/metroui/oeobjects/',
        "css" => [],
        "js"  => [],
	],
];
?>
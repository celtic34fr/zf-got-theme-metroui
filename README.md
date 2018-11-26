# GraphicObjectTemplating Theme MetroUI (zf-got-theme-metroui)

This graphic theme for **GraphicObjectTemplating** give you the brick to build and manage your own MetroUI UI.

## Before any Installation ##

You must have install the packages : *celtic34fr/zf-graphic-object-templating* and *celtic34fr/zf-got-twig-extension*, development version by the following commands :

    composer.phar require celtic34fr/zf-graphic-object-templating @dev 
    composer.phar require celtic34fr/zf-got-twig-extension @dev 

## Installation using Composer

After that, you install this package with :

    composer.phar require celtic34fr/zf-got-theme-metroui @dev
    
In order to use the installed module, you need to configure your application as follows:

First, in **config/modules.config.php** file, add the following line :

    ...
    'MetroUI_GET',
    ...
In public folder of your project, first create a folder named gotextension.
In this folder, create a linked directory with the vendor/celtic34fr/zf-got-theme-metroui/public directory named metroui with the following command executed on Linux :

    cd public
    mkdir gotextension
    cd gotextension
    ln -s ../../vendor/celtic34fr/zf-got-theme-metroui/public metroui

For Windows environment use only cmd.exe, the command exected as administrator in public folder became :

    cd public
    mkdir gotextension
    cd gotextension
    mklink /D metroui ..\..\vendor\celtic34fr\zf-got-theme-metroui\public

Now, all is is ordre to work. You can begin to develop your own extension by adding a new module to your project, your application.
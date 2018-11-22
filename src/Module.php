<?php

namespace MetroUI_GET;
 
use GraphicObjectTemplating\OObjects\OObject;
use MetroUI_GET\GotObjects\HeaderMenuMGET;
use MetroUI_GET\GotObjects\SideMenuMGET;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface {
 
    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
//        $eventManager        = $e->getApplication()->getEventManager();
//        $moduleRouteListener = new ModuleRouteListener();
//        $moduleRouteListener->attach($eventManager);
//
        $sessionObjects     = OObject::validateSession();
        if (!OObject::existObject('HeaderMenuMGET', $sessionObjects)) {
            $adminHeaderMenu    = new HeaderMenuMGET();
            $adminHeaderMenu->removeChildren();
            $adminHeaderMenu->init();
        }

        if (!OObject::existObject('SideMenuMGET', $sessionObjects)) {
            $adminSideMenu       = new SideMenuMGET();
            $adminSideMenu->removeChildren();
            $adminSideMenu->init();
        }

//        /* insertion variable globale dans TWIG */
//        $twigEnv = $e->getApplication()->getServiceManager()->get('Twig_Environment');
//        $twigEnv->addGlobal('sideMenuMGET', $adminSideMenu);
//        $twigEnv->addGlobal('headerMenuMGET', $adminHeaderMenu);
    }

}

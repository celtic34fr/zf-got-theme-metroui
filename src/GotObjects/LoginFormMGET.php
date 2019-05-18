<?php

namespace MetroUI_GET\GotObjects;

use G7Auth\Service\AuthManager;
use G7Auth\Service\UserManager;
use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\ODContained\ODCheckbox;
use GraphicObjectTemplating\OObjects\ODContained\ODInput;
use GraphicObjectTemplating\OObjects\ODContained\ODNotification;
use GraphicObjectTemplating\OObjects\OSContainer\OSForm;
use GraphicObjectTemplating\OObjects\OObject;
use MetroUI_GET\OEObjects\OEDContained\OEDInput;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mvc\Controller\Plugin\Url;
use Zend\ServiceManager\ServiceManager;

class LoginFormMGET extends OSForm
{
    /** @var OEDInput $usernameLFG */
    protected $usernameLFG;
    /** @var OEDInput $passwordLFG */
    protected $passwordLFG;

    /** @var ODCheckbox $rememberMeLFG */
    protected $rememberMeLFG;
    /** @var ODButton $forgetPassLFG */
    protected $forgetPassLFG;
    /** @var ODButton $notRegisterLFG */
    protected $notRegisterLFG;

    /** @var ODNotification $notificationLFG */
    protected $notificationLFG;


    const FAILURE_NOT_LOGGED_SAME_USER = -5;

    public function __construct($first = false)
    {
        if ($first) {
            self::destroyObject('', true);
        }
        parent::__construct('loginFormMGET');
        $this->setClassName(self::class);
    }

    public function init()
    {
        $this->usernameLFG      = new OEDInput('usernameLFG');
        $this->passwordLFG      = new OEDInput('passwordLFG');

        $this->rememberMeLFG    = new ODCheckbox('rememberMeLFG');
        $this->forgetPassLFG    = new ODButton('forgetPassLFG');
        $this->notRegisterLFG   = new ODButton('notRegisterLFG');

        $this->notificationLFG  = new ODNotification('notificationLFG');

        $this->usernameLFG->setLabel('Username');
        $this->usernameLFG->setType(ODInput::INPUTTYPE_TEXT);
        $this->usernameLFG->setLabelWidthBT(4);
        $this->usernameLFG->setClasses('ospaddingV02');
        $this->usernameLFG->enaAutoFocus();
        $this->usernameLFG->saveProperties();

        $this->passwordLFG->setLabel('Password');
        $this->passwordLFG->setType(ODInput::INPUTTYPE_PASSWORD);
        $this->passwordLFG->setLabelWidthBT(4);
        $this->passwordLFG->setClasses('ospaddingV02');
        $this->passwordLFG->saveProperties();


        $this->rememberMeLFG->addOption(1, 'Remember Me');
        $this->rememberMeLFG->setClasses('ospaddingV02');
        $this->rememberMeLFG->saveProperties();

        $this->forgetPassLFG->setLabel("Forgot your password ?");
        $this->forgetPassLFG->setType(ODButton::BUTTONTYPE_LINK);
        $this->forgetPassLFG->setNature(ODButton::BUTTONNATURE_LINK);
        $this->forgetPassLFG->setClasses('ospaddingV02');
        $this->forgetPassLFG->setClasses('ospaddingV05');

        $this->notRegisterLFG->setLabel("Not yet registered ?");
        $this->notRegisterLFG->setType(ODButton::BUTTONTYPE_LINK);
        $this->notRegisterLFG->setNature(ODButton::BUTTONNATURE_LINK);
        $this->notRegisterLFG->setClasses('ospaddingV02');
        $this->notRegisterLFG->setClasses('ospaddingV05');

        $this->notificationLFG->setAction(ODNotification::NOTIFICATIONACTION_INIT);
        $this->notificationLFG->setPosition(ODNotification::NOTIFICATIONPOSITION_BR);
        $this->notificationLFG->disSound();
        $this->notificationLFG->saveProperties();

        $this->addChild($this->usernameLFG, true);
        $this->addChild($this->passwordLFG, true);

        $this->addChild($this->rememberMeLFG, false);
        $this->addChild($this->forgetPassLFG, false);
        $this->addChild($this->notRegisterLFG, false);

        $this->addChild($this->notificationLFG, false);

//        $this->enaAutoCenter('25em', '12em');
        $this->enaAutoCenter();
        $this->setACWidthHeight('30em', '16em');
//        $this->setStyle('border: 2px solid black;background-color: white;');
        $this->addCodeCss('body', 'background-color:darkBlue;');
        $this->addCodeCss('hr', 'display:none;');
        $this->addCodeCss("footer", "color: white !important;text-align:right;padding-right:3em;");
        $this->addCodeCss('#loginFormMGET','padding: 2em;border: 1px solid black;
            border-radius: 1em;box-shadow: #4d4d4d 0.25em 0.25em 0.5em;');

        $this->addBtn('signin',
            'Sign in',
            '',
            0,
            ODButton::BUTTONTYPE_SUBMIT,
            ODButton::BUTTONNATURE_SUCCESS,
            1,
            self::class,
            'evtLoginUser');
        $this->saveProperties();
        $this->setDefaultBtn('signin');


        $this->disRememberMe();
        $this->disForgetPass();
        $this->disNotRegister();

        $this->saveProperties();
        return $this;
    }

    /**
     * callback sur évènerment
     */

    public function evtLoginUser(ServiceManager $sm, array $params) {
        $sessionObjects = self::validateSession();
        $ret = [];
        $gs = $sm->get('graphic.object.templating.services');
        /** @var AuthManager $am */
        $am = $sm->get(AuthManager::class);
        /** @var UserManager $um */
        $um = $sm->get(UserManager::class);
        $um->createAdminUserIfNotExists();

        /** @var OSForm loginFormMGET */
        $loginFormMGET = self::buildObject('loginFormMGET', $sessionObjects);
        /** @var ODNotification $notificationLFG */
        $notificationLFG    = self::buildObject('notificationLFG', $sessionObjects);
        $notificationLFG->setAction(ODNotification::NOTIFICATIONACTION_SEND);
        $notif              = [];
        $notif['id']        = 'notificationLFG';
        $notif['mode']      = 'update';

        $valid = $loginFormMGET->isValid($params['form']);
        if ($valid['valid'] == 'OK') {
            $usernameLFG    = $passwordLFG  = $rememberMeLFG =  $forgetPassLFG = '';
            extract($params['form'], EXTR_IF_EXISTS);
            /** @var Result $result */
            $result         = $am->login($usernameLFG, $passwordLFG, $rememberMeLFG);

            if ($result->getCode() == Result::SUCCESS) {
                /** @var Url $url */
                $url    = $sm->get('ControllerPluginManager')->get(Url::class);
                $homeUrl = $url->fromRoute('dashboard');
                $item   = OObject::formatRetour($params['id'], $params['id'], "redirect", $homeUrl);
                $ret[]          = $item;
            } else {
                $msgs   = $result->getMessages();
                $msgRc  = '';
                foreach ($msgs as $msg) {
                    $msgRc .= $msg . ' ';
                }
                $notificationLFG->setTitle('ERREUR');
                $notificationLFG->setBody($msgRc);
                $notificationLFG->setType(ODNotification::NOTIFICATIONTYPE_ERROR);
                $notificationLFG->saveProperties();
                $notif['html'] = $gs->render($notificationLFG);
                $ret[] = OObject::formatRetour($notif['id'], $notif['id'], $notif['mode'], $notif['html']);;

                if ($result->getCode() == self::FAILURE_NOT_LOGGED_SAME_USER) {
                    /** @var Url $url */
                    $url    = $sm->get('ControllerPluginManager')->get(Url::class);
                    $homeUrl = $url->fromRoute('logout');
                    $item   = OObject::formatRetour($params['id'], 5000, "redirect", $homeUrl);
                    $ret[]          = $item;
                }
            }
        } else {
            $notificationLFG->setTitle('ERREUR');
            $notificationLFG->setBody($valid['msg']);
            $notificationLFG->setType(ODNotification::NOTIFICATIONTYPE_ERROR);
            $notificationLFG->saveProperties();
            $notif['html'] = $gs->render($notificationLFG);
            $ret[] = OObject::formatRetour($notif['id'], $notif['id'], $notif['mode'], $notif['html']);;
        }
        return $ret;
    }

    /**
     * méthode extene pour gestion de l'objet
     */

    public function enaRememberMe()
    {
        $this->rememberMeLFG->setDisplay(self::DISPLAY_BLOCK);
        $this->rememberMeLFG->enable();
        $this->rememberMeLFG->saveProperties();
        $this->setFormHeigth();
        $this->saveProperties();
    }

    public function disRememberMe()
    {
        $this->rememberMeLFG->setDisplay(self::DISPLAY_NONE);
        $this->rememberMeLFG->disable();
        $this->rememberMeLFG->saveProperties();
        $this->setFormHeigth();
        $this->saveProperties();
    }

    public function enaForgetPass()
    {
        $this->forgetPassLFG->setDisplay(self::DISPLAY_BLOCK);
        $this->forgetPassLFG->enable();
        $this->forgetPassLFG->saveProperties();
        $this->setFormHeigth();
        $this->saveProperties();
    }

    public function disForgetPass()
    {
        $this->forgetPassLFG->setDisplay(self::DISPLAY_NONE);
        $this->forgetPassLFG->disable();
        $this->forgetPassLFG->saveProperties();
        $this->setFormHeigth();
        $this->saveProperties();
    }

    public function enaNotRegister()
    {
        $this->notRegisterLFG->setDisplay(OObject::DISPLAY_BLOCK);
        $this->notRegisterLFG->enable();
        $this->notRegisterLFG->saveProperties();
        $this->setFormHeigth();
        $this->saveProperties();
    }

    public function disNotRegister()
    {
        $this->notRegisterLFG->setDisplay(OObject::DISPLAY_NONE);
        $this->notRegisterLFG->disable();
        $this->notRegisterLFG->saveProperties();
        $this->setFormHeigth();
        $this->saveProperties();
    }

    public function setCallbackSignIn(ServiceManager $sm, $route, array $params = null)
    {
        $parmString = $this->validateRouteParams($sm, $route, $params);
        if ($parmString !== false) {
            $sessionObjects         = OObject::validateSession();
            /** @var ODButton $signinloginFormMGET */
            $signinloginFormMGET    = OObject::buildObject('signinloginFormMGET', $sessionObjects);
            $signinloginFormMGET->evtClick($route, $parmString);
            $signinloginFormMGET->saveProperties();
            return $this;
        }
        return false;
    }

    public function setUrlForgetPass(ServiceManager $sm, $route, array $params = null)
    {
        $parmString = $this->validateRouteParams($sm, $route, $params);
        if ($parmString !== false) {
            $this->forgetPassLFG->evtClick($route, $parmString);
            $this->forgetPassLFG->saveProperties();
            return $this;
        }
        return false;
    }

    public function setUrlNotRegister(ServiceManager $sm, $route, array $params = null)
    {
        $parmString = $this->validateRouteParams($sm, $route, $params);
        if ($parmString !== false) {
            $this->notRegisterLFG->evtClick($route, $parmString);
            $this->notRegisterLFG->saveProperties();
            return $this;
        }
        return false;
    }

    /**
     * méthodes privées de l'objet
     */

    private function validateRouteParams(ServiceManager $sm, $route, array $params = null)
    {
        $route  = (string) $route;
        if (!empty($route)) {
            $urlFP  = "";
            /** @var Url $url */
            $url    = $sm->get('ControllerPluginManager')->get(Url::class);
            try {
                if (empty($params) || sizeof($params) < 1) {
                    $urlFP = $url->fromRoute($route);
                } else {
                    $urlFP = $url->fromRoute($route, $params);
                }
            } catch (\Exception $e) {
                return false;
            }
            if (!empty($urlFP)) {
                $parmString = "";
                foreach ($params as $key => $param) {
                    $parmString .= $key . ':' . $param . '|';
                }
                return $parmString;
            }
        }
        return false;
    }

    private function setFormHeigth()
    {
        $height = 11;

        $nbElts = (int) $this->rememberMeLFG->getState() +
            (int) $this->forgetPassLFG->getState() +
            (int) $this->notRegisterLFG->getState();

        switch ($nbElts) {
            case 1:
                if ($this->rememberMeLFG->getState() == self::STATE_ENABLE) {
                    $height += 3;
                    $this->rememberMeLFG->setClasses('ospaddingV02');
                }
                if ($this->forgetPassLFG->getState() == self::STATE_ENABLE) {
                    $height += 3;
                    $this->forgetPassLFG->setClasses('ospaddingV05');
                }
                if ($this->notRegisterLFG->getState() == self::STATE_ENABLE) {
                    $height += 3;
                    $this->notRegisterLFG->setClasses('ospaddingV05');
                }
                break;
            case 2:
                if ($this->rememberMeLFG->getState() == self::STATE_ENABLE) {
                    $height += 3;
                    $this->rememberMeLFG->setClasses('ospaddingV01');
                }
                if ($this->forgetPassLFG->getState() == self::STATE_ENABLE) {
                    $height += 3;
                    $this->forgetPassLFG->setClasses('ospaddingV01');
                }
                if ($this->notRegisterLFG->getState() == self::STATE_ENABLE) {
                    $height += 3;
                    $this->notRegisterLFG->setClasses('ospaddingV01');
                }
                break;
            case 3:
                $height += 9;
                $this->rememberMeLFG->setClasses('ospaddingV01');
                $this->forgetPassLFG->setClasses('ospaddingV01');
                $this->notRegisterLFG->setClasses('ospaddingV01');
                break;
        }

        $this->setACHeight($height.'em');
    }

}

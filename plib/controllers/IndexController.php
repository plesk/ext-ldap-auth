<?php
// Copyright 1999-2019. Plesk International GmbH.
class IndexController extends pm_Controller_Action
{

    public function init()
    {
        parent::init();

        if (!pm_Session::getClient()->isAdmin()) {
            throw new pm_Exception('Permission denied');
        }
    }

    public function indexAction()
    {
        $this->view->pageTitle = $this->lmsg('settingsPageTitle');

        $form = new Modules_LdapAuth_Form_Settings();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $form->process();
            $this->_status->addMessage('info', $this->lmsg('settingsSaved'));
            $this->_helper->json(array('redirect' => pm_Context::getModulesListUrl()));
        }

        $this->view->form = $form;
    }
}

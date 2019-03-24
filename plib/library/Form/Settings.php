<?php
// Copyright 1999-2019. Plesk International GmbH.
class Modules_LdapAuth_Form_Settings extends pm_Form_Simple
{

    public function init()
    {
        $this->addElement('checkbox', 'enable', array(
            'label' => $this->lmsg('fieldEnable'),
            'value' => (bool)pm_Settings::get('enable'),
        ));

        $this->addElement('text', 'host', array(
            'label' => $this->lmsg('fieldHost'),
            'value' => pm_Settings::get('host'),
        ));

        $this->addElement('checkbox', 'ssl', array(
            'label' => $this->lmsg('fieldSsl'),
            'value' => pm_Settings::get('ssl'),
        ));

        $this->addElement('text', 'loginPrefix', array(
            'label' => $this->lmsg('fieldLoginPrefix'),
            'value' => pm_Settings::get('loginPrefix', 'DOMAIN\\'),
        ));

        $this->addElement('text', 'loginSuffix', array(
            'label' => $this->lmsg('fieldLoginSuffix'),
            'value' => pm_Settings::get('loginSuffix'),
        ));

        $this->addElement('checkbox', 'disableNativeAuth', array(
            'label' => $this->lmsg('fieldDisableNativeAuth'),
            'value' => (bool)pm_Settings::get('disableNativeAuth'),
        ));

        $this->addControlButtons(array(
            'cancelHidden' => true,
        ));
    }

    public function process()
    {
        $values = $this->getValues();
        pm_Settings::set('enable', (bool)$values['enable']);
        pm_Settings::set('host', $values['host']);
        pm_Settings::set('ssl', $values['ssl']);
        pm_Settings::set('loginPrefix', $values['loginPrefix']);
        pm_Settings::set('loginSuffix', $values['loginSuffix']);
        pm_Settings::set('disableNativeAuth', (bool)$values['disableNativeAuth']);
    }

}

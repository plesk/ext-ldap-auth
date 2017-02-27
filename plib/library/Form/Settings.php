<?php
// Copyright 1999-2017. Parallels IP Holdings GmbH.
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

        $this->addElement('text', 'loginPrefix', array(
            'label' => $this->lmsg('fieldLoginPrefix'),
            'value' => pm_Settings::get('loginPrefix', 'DOMAIN\\'),
        ));

        if (version_compare(pm_ProductInfo::getVersion(), '12.5.29', '>=')) {
            $this->addElement('checkbox', 'disableNativeAuth', array(
                'label' => $this->lmsg('fieldDisableNativeAuth'),
                'value' => (bool)pm_Settings::get('disableNativeAuth'),
            ));
        }

        $this->addControlButtons(array(
            'cancelHidden' => true,
        ));
    }

    public function process()
    {
        $values = $this->getValues();
        pm_Settings::set('enable', (bool)$values['enable']);
        pm_Settings::set('host', $values['host']);
        pm_Settings::set('loginPrefix', $values['loginPrefix']);

        if (version_compare(pm_ProductInfo::getVersion(), '12.5.29', '>=')) {
            pm_Settings::set('disableNativeAuth', (bool)$values['disableNativeAuth']);
        }
    }

}

<?php
// Copyright 1999-2019. Plesk International GmbH.
class Modules_LdapAuth_Auth extends pm_Hook_Auth
{

    public function auth($login, $password)
    {
        \pm_Log::debug('LDAP server connecting...');

        $ch = curl_init();
        $protocol = "ldap://";
        $port = "389";
        if ((bool)pm_Settings::get('ssl')) {
            $protocol = "ldaps://";
            $port = "636";
        }

        curl_setopt($ch, CURLOPT_URL, $protocol . pm_Settings::get('host') . ":" . $port);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, pm_Settings::get('loginPrefix') . $login . pm_Settings::get('loginSuffix') . ":" . $password);
        $result = curl_exec($ch);
        if ($result === false) {
            \pm_Log::err('LDAP server communication failed: ' . curl_error($ch));
        } else {
            \pm_Log::debug('LDAP server communication succeed');
        }
        curl_close($ch);

        return false !== $result;
    }

    public function isEnabled()
    {
        return (bool)pm_Settings::get('enable');
    }

    public function breakChainOnFailure()
    {
        return (bool)pm_Settings::get('disableNativeAuth');
    }

}

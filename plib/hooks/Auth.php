<?php
// Copyright 1999-2017. Parallels IP Holdings GmbH.
class Modules_LdapAuth_Auth extends pm_Hook_Auth
{

    public function auth($login, $password)
    {
        $ch = curl_init();
        $protocol = "ldap://";
        $port = "389";
        if (pm_Settings::get('ssl') == true) {
            $protocol = "ldaps://";
            $port = "636";
        }

        curl_setopt($ch, CURLOPT_URL, $protocol . pm_Settings::get('host') . ":" . $port);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, pm_Settings::get('loginPrefix') . $login . pm_Settings::get('loginSuffix') . ":" . $password);
        $result = curl_exec($ch);
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

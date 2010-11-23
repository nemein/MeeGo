<?php

ldap_auth_pre_callback($argv[1]);

/**
 * do a midgard query for username
 * return if username alresdy eixst in db
 * otherwise do an _ldap_search for username
 * if user exists in LDAP then create an account in db
 * if user does not exist then .. give up :)
 */
function ldap_auth_pre_callback($username) {
    var_dump(_ldap_search($username));
    return;
}

/**
 * Performs an LDAP search
 *
 * @param string username to search for in LDAP
 * @return Array with username (uid), firtname (cn) and email (mail) coming from LDAP
 */
function _ldap_search($criteria)
{
    $retval = null;
    if (isset($criteria))
    {
        $criteria .= 'uid=' . $criteria;

        $ds = ldap_connect("ldaps://ldap1.meego.com");
        echo "Connect result is " . $ds . "\n";

        if ($ds)
        {
            echo "Searching for $criteria\n";

            // Search surname entry
            $sr = ldap_search($ds, "ou=People,dc=meego,dc=com", $criteria);

            echo "Search result is: " . $sr . "\n";
            echo "Number of entires returned is: " . ldap_count_entries($ds, $sr) . "\n";
            echo "Getting entries ...\n";

            $info = ldap_get_entries($ds, $sr);

            echo "Data for " . $info["count"] . " items returned:\n";

            if ($info['count'] > 0) {
                $retval = array(
                    'username' => $info[0]["uid"][0],
                    'firtname' => $info[0]["cn"][0],
                    'email' => $info[0]["mail"][0]
                );
            }
            echo "Closing connection\n";
            ldap_close($ds);
        }
    }
    else
    {
        echo "Unable to connect to LDAP server\n";
    }
    return $retval;
}

?>

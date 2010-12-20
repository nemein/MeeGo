<?php

/**
 * do a midgard query for username
 * return if username alresdy eixst in db
 * otherwise do an _ldap_search for username
 * if user exists in LDAP then create an account in db
 * if user does not exist then .. give up :)
 */
function ldap_auth_pre_callback($username)
{
    $qb = new midgard_query_builder('midgard_person');
    $qb->add_constraint('username', '=', $username);
    if ($qb->count() > 0)
    {
        return;
    }
    else
    {
        $ldap_user = _ldap_search($username);
        if ($ldap_user)
        {
            $user = new midgard_person();
            $user->username = $ldap_user['username'];
            $user->firstname = $ldap_user['firstname'];
            $user->email = $ldap_user['email'];
            $user->create();
            // use this parameter to fetch avatars from meego.com
            $user->set_parameter('org.maemo.socialnews', 'employeenumber', $ldap_user['employeenumber']);
        }

    }
    unset($ldap_user);
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
    if ( ! isset($criteria) )
    {
        return $retval;
    }
    else
    {
        $criteria = 'uid=' . $criteria;

        $ds = ldap_connect("ldaps://ldap1.in.<meego.com");

        if ( ! $ds )
        {
            return $retval;
        }
        else
        {
            $sr = ldap_search($ds, "ou=People,dc=meego,dc=com", $criteria);

            $info = ldap_get_entries($ds, $sr);

            if ($info['count'] > 0) {

                $retval = array(
                    'username' => $info[0]["uid"][0],
                    'firstname' => $info[0]["cn"][0],
                    'email' => $info[0]["mail"][0],
                    'employeenumber' => $info[0]["employeenumber"][0]
                );
            }
            ldap_close($ds);
        }
    }
    return $retval;
}

?>

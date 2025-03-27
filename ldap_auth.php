<?php

/*
    POC!!!
*/

if (isset($username) and isset($password)) {

$mail = $username;
$pass = $password;

$debug = 1;

$ldap_bind_user = "GoogleLDAPuser";
$ldap_bind_pass = "GoogleLDAPpass-63.......AL";
$ldap_crt_file_path = "/var/www/portal.cmm.lt/web/guest/s/default/crt/Google_2024_01_17_50984.crt";
$ldap_key_file_path = "/var/www/portal.cmm.lt/web/guest/s/default/crt/Google_2024_01_17_50984.key";

$ldap_valid_login_type = false;
$ldap_valid_domain = false;
$ldap_valid_user = false;
$ldap_valid_group = false;

function log_message($message, $debug=0) {
  if ($debug === 0)
    return true;
  elseif ($debug === 1)
    return error_log($message);
}

// Check email format

if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  $ldap_valid_login_type = true;
  log_message ("$mail is a valid email address", $debug);
} else {
  log_message ("$mail is not a valid email address", $debug);
}

// check allowed domains

if ($ldap_valid_login_type) {
  $mail_parts = explode('@', $mail);
  $mail_user = strtolower($mail_parts[0]);
  $mail_domain = strtolower($mail_parts[1]);
  log_message ("Split $mail to '$mail_user' and '$mail_domain'", $debug);

  if ($mail_domain == 'p.cmm.lt') {
    $ldap_valid_domain = true;
    $ldap_dn = "ou=Users,dc=p,dc=cmm,dc=lt";
    log_message ("$mail_domain dn='$ldap_dn'", $debug);
  } elseif ($mail_domain == 'm.cmm.lt') {
    $ldap_valid_domain = true;
    $ldap_dn = "ou=Users,dc=m,dc=cmm,dc=lt";
    log_message ("$mail_domain dn='$ldap_dn'", $debug);
  } elseif ($mail_domain == 'it.cmm.lt') {
    $ldap_valid_domain = true;
    $ldap_dn = "ou=Users,dc=it,dc=cmm,dc=lt";
    log_message ("$mail_domain dn='$ldap_dn'", $debug);
  } else {
    log_message ("$mail_domain not allowed", $debug);
  }
}

// User login

if ($ldap_valid_login_type and $ldap_valid_domain) {

log_message ("$mail: ldap_valid_login_type=$ldap_valid_login_type and ldap_valid_domain=$ldap_valid_domain check ldap user", $debug);

$ldap_connect=ldap_connect("ldap.google.com");
ldap_set_option(NULL, LDAP_OPT_X_TLS_CERTFILE, $ldap_crt_file_path);
ldap_set_option(NULL, LDAP_OPT_X_TLS_KEYFILE, $ldap_key_file_path);
ldap_set_option($ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_connect, LDAP_OPT_REFERRALS, 0);
$ldap_tls_connect = @ldap_start_tls($ldap_connect);

if (@$ldap_tls_connect) {
  log_message ("$mail: ldap_tls_connect=ok ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

  if (@$ldap_connect) {
    log_message ("$mail: ldap_connect=ok ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

    $ldap_bind = @ldap_bind($ldap_connect, $mail_user."@".$mail_domain, $pass);
    if ($ldap_bind) {
      $ldap_valid_user = true;
      log_message ("$mail: ldap_bind=ok ".ldap_err2str(ldap_errno($ldap_connect)), $debug);
      log_message ("$mail: ldap_valid_user=$ldap_valid_user", $debug);

      $ldap_search = ldap_search($ldap_connect, "dc=cmm,dc=lt", "(mail=".$mail_user."@".$mail_domain.")", array("mail","dn","uidnumber","gidnumber"));
      $ldap_get_entries = ldap_get_entries($ldap_connect, $ldap_search);
      $ldap_data_user = (array) $ldap_get_entries;
      log_message ("$mail: ".json_encode($ldap_data_user), $debug);

    } else log_message ("$mail: ldap_bind=fail ldap_valid_user=$ldap_valid_user ".ldap_err2str(ldap_errno($ldap_connect)), $debug);
  } else log_message ("$mail: ldap_connect=fail ".ldap_err2str(ldap_errno($ldap_connect)), $debug);
} else log_message ("$mail: ldap_tls_connect=fail ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

ldap_close($ldap_connect);

// group check

if ($ldap_valid_user === true) {

log_message ("A $mail: ldap_valid_user=$ldap_valid_user check group", $debug);

$ldap_connect=ldap_connect("ldap.google.com");
ldap_set_option(NULL, LDAP_OPT_X_TLS_CERTFILE, $ldap_crt_file_path);
ldap_set_option(NULL, LDAP_OPT_X_TLS_KEYFILE, $ldap_key_file_path);
ldap_set_option($ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_connect, LDAP_OPT_REFERRALS, 0);
$ldap_tls_connect = @ldap_start_tls($ldap_connect);

if (@$ldap_tls_connect) {
  log_message ("A $mail: ldap_tls_connect=ok ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

  if (@$ldap_connect) {
    log_message ("A $mail: ldap_connect=ok ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

    $ldap_bind = @ldap_bind($ldap_connect, $ldap_bind_user, $ldap_bind_pass);
    if ($ldap_bind) {
      log_message ("A $mail: ldap_bind=ok ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

      $ldap_search = ldap_search($ldap_connect, $ldap_dn, "(mail=".$mail_user."@".$mail_domain.")", array("memberof"));
      $ldap_get_entries = ldap_get_entries($ldap_connect, $ldap_search);
      $ldap_data_group = (array) $ldap_get_entries;
      log_message ("A $mail: ".json_encode($ldap_data_group), $debug);

      foreach ($ldap_data_group[0]['memberof'] as $k => $v) {
        if (is_int($k)) {
          $memberof_parts = explode(',', $v);
          if (in_array('cn=group_allow_wifi', $memberof_parts)) {
            $ldap_valid_group = true;
            log_message ("A $mail: ldap_valid_group=$ldap_valid_group ".$v, $debug);
          }
        }
      }

    } else log_message ("A $mail: ldap_bind=fail ldap_valid_user=$ldap_valid_user ".ldap_err2str(ldap_errno($ldap_connect)), $debug);
  } else log_message ("A $mail: ldap_connect=fail ".ldap_err2str(ldap_errno($ldap_connect)), $debug);
} else log_message ("A $mail: ldap_tls_connect=fail ".ldap_err2str(ldap_errno($ldap_connect)), $debug);

ldap_close($ldap_connect);

}

}

}

?>

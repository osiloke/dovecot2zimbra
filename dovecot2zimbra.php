#!/usr/bin/php
<?php
/**
 *
 * PHP Version 5.3
 *
 * @author Ruben Lacasa Mas <ruben@rubenlacasa.es>
 * @copyright 2013 Ruben Lacasa Mas http://rubenlacasa.es
 * @license http://creativecommons.org/licenses/by-nc-nd/3.0
 * CC-BY-NC-ND-3.0
 * @link
 */
$usersFile = 'dovecotusers.tab'; //dovecot Users file
$hostOrigin = 'mail.origin.com'; // Mailserver Origin
$hostDest = 'mail.dest.com'; // Mailserver Dest
$masterUser1 = 'masterUserOrigin'; // Master User Server Origin
$masterPwd1 = 'masterUserOriginPwd'; // Master User Server Origin Password
$masterUser2 = 'masterUserDest'; // Master User Server Dest
$masterPwd2 = 'masterUserDestPwd'; // Master User Server Dest Password
$domain = false; // retrive the actual domain
$onlySync = false;
if (is_file($usersFile)) {
    $file = file($usersFile);
    foreach ($file as $line) {
        $data = explode(":", $line);
        $userMail = trim($data[0]);
        $userPass = trim($data[1]);
        // Set true for only sync accounts
	    if (!$onlySync) {
            //Create Domain if not exists
            $mailParts = explode("@", $userMail);
            if (trim($mailParts[1]) != $domain) {
                $domain = trim($mailParts[1]);
	            echo "Creating domain " . $domain . PHP_EOL;
                exec("zmprov createDomain ".$domain);
            }
            // User creation
	        echo "Creating user ".$userMail . PHP_EOL;
            exec("zmprov ca " . $userMail . " changePassword");
            // If find CRAM-MD5 set the default password and User must change
            if (!preg_match('/CRAM-MD5/', $userPass)) {
	            echo "Setting user ".$userMail ." password ". PHP_EOL;
                exec("zmprov ma " . $userMail . " userPassword " . "'{crypt}" . $userPass . "'");
            } else {
                echo "Setting password must change for user " . $userMail . PHP_EOL;
                echo("zmprov ma " . $userMail . " zimbraPasswordMustChange TRUE");
            }
        }
	    echo "Syncing User " . $userMail . " from " . $hostOrigin . " to " . $hostDest . PHP_EOL;
        // Mailbox migration
        exec("imapsync --nosyncacls --syncinternaldates \--host1   " . $hostOrigin . " --user1 " . $userMail . " --authuser1 " . $masterUser . " --password1 " . $masterPwd . " \--host2 " . $hostDest . " --user2 " . $userMail . " --authuser2 " . $masterUser2 . " --password2 " . $masterPwd2 . " --ssl2");
    }
}

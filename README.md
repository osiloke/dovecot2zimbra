#DOVECOT2ZIMBRA

+ **Description:** PHP Script to migrate Dovecot emails users and Mailboxes to Zimbra
+ **PHP Version:** 5.3
+ **Developer:** Ruben Lacasa Mas(c) 2013 <http://rubenlacasa.es>
+ Based on http://wiki.zimbra.com/wiki/Migrating_from_Dovecot_passwd_with_bash

##LICENSE

Creative Commons Attribution-NonCommercial-NoDerivs 3.0
=======================================================

Copyright (c) 2013 Ruben Lacasa Mas <ruben@ensenalia.com>

This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License.
To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/3.0/ or send a letter
to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.

##REQUERIMENTS

+ imapsync http://imapsync.lamiral.info/
+ PHP5-cli

##USE

+ Log in Zimbra server as root
+ user@zimbraserver~# sudo su
+ Copy or move the docecotusers.tab and dovecot2zimbra.php to zimbra home, usually /opt/zimbra
+ Change owner of to files
+ root@zimbraserver~# chown zimbra dovecot2zimbra.php dovecotusers.tab
+ Log as zimbra user
+ root@zimbraserver# su - zimbra
+ Set the hostname of origin mailserver, destination mailserver and the master user and password of mail server origin and destination.
+ Execute script
+ zimbra@zimbraserver~#./dovecot2zimbra.php

##KNOWN BUGS

+ Not import CRAM-MD5 passwords

##FAQS

+ How to set master user of dovecot? Read http://wiki2.dovecot.org/Authentication/MasterUsers
+ Error for file attachments too large? Read http://wiki.zimbra.com/wiki/Guide_to_imapsync#Enabling_Emails_With_Large_File_Attachments_.28Zimbra_IMAP_Max_Size_is_10mb.29

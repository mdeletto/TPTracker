# XatafaceLDAPauth

[![Version][mg_BadgeVersion]][ln_ReleaseLatest]
[![License][mg_BadgeLicense]][ln_License]
[![Issues][mg_BadgeIssues]][ln_Issues]
![Language][mg_BadgeCodeLang]

This is a module for authenticating *Xataface* users against a LDAP directory


## Installation


### Pre-requisites

The file in this repository `ldap.php` is launcher for the module. Additional dependencies include the following.

*  *phpLDAPauth* (https://bitbucket.org/viharm/phpldapauth)
*  *phpDBauth* (https://bitbucket.org/viharm/phpdbauth)


### Download

Download the LDAP module


#### Archive

Get the release archives from [downloads][ln_ReleaseLatest]


#### Clone repository

Clone the repository into the *Xataface* installation; remember to pull sub-modules by recursion
```
git clone --recurse-submodules \
https://bitbucket.org/viharm/xatafaceldapauth.git \
%DATAFACE_PATH%/modules/Auth/ldap/
```


### Deploy
Extract the contents of the archive into the `.../xataface/modules/` directory. You should have a directory structure like the following:

* `%DATAFACE_PATH%/modules/Auth/ldap/README.md`
* `%DATAFACE_PATH%/modules/Auth/ldap/LICENSE.txt`
* `%DATAFACE_PATH%/modules/Auth/ldap/VERSION.txt`
* `%DATAFACE_PATH%/modules/Auth/ldap/version.txt`
* `%DATAFACE_PATH%/modules/Auth/ldap/ldap.php`
* `%DATAFACE_PATH%/modules/Auth/ldap/phpldapauth/`
    * `%DATAFACE_PATH%/modules/Auth/ldap/phpldapauth/phpldapauth.php`
    * `%DATAFACE_PATH%/modules/Auth/ldap/phpldapauth/...`
* `%DATAFACE_PATH%/modules/Auth/ldap/phpdbauth/`
    * `%DATAFACE_PATH%/modules/Auth/ldap/phpmysqlauth/phpdbauth.php`
    * `%DATAFACE_PATH%/modules/Auth/ldap/phpmysqlauth/...`
* `%DATAFACE_PATH%/modules/Auth/ldap/Lib/`
    * `%DATAFACE_PATH%/modules/Auth/ldap/Lib/fl_Lib.inc.php`
    * `%DATAFACE_PATH%/modules/Auth/ldap/Lib/kint/`
        * `%DATAFACE_PATH%/modules/Auth/ldap/Lib/kint/...`
* `%DATAFACE_PATH%/modules/Auth/ldap/ldap_original.php`


## Configuration

Add the following section to your application's `conf.ini` file.

```ini
[_auth]
  auth_type=ldap
  users_table="User"
  username_column="username"
  ldap_host = "ldap.domain.tld"
  ldap_port = "389"
  ldap_base = "ou=Users,dc=ldap,dc=domain,dc=tld"
```

If using Active Directory, then please specify (in addition to the above) the server type and the user's domain as follows:

For Active Directory Domain Services (AD DS)
```ini
  ldap_type="ad-ds"
  ldap_userdomain="NETBIOSDOMAIN"
```

For Active Directory Lightweight Directory Services (AD LDS)
```ini
  ldap_type="ad-lds"
  ldap_userdomain="dnsdomain.com"
```

Replace the above values with those relevant/appropriate to the application environment.


### Optional features and settings

The example `conf.ini` shown earlier includes the minimum options required to get started.

Additional configuration options include.


#### Group membership

`ldap_groupname` can be used to specify the LDAP group which a user must belong to, to be authenticated.

```
ldap_groupname = "xatafaceusersgroup"
```

If this option is not specified, group membership is not checked, and any user who can bind to the directory using their directory username and password is authenticated.


#### Username attribute

`ldap_usernameattrib` specifies the attribute used to identify user names in the directory environment..

```
ldap_usernameattrib = "uid"
```

If not specified, the OpenLDAP default of `uid` is used.


#### Group name attribute

`ldap_groupnameattrib` specifies the attribute used to identify group names in the directory environment..

```
ldap_groupnameattrib = "cn"
```

If not specified, the OpenLDAP default of `cn` is used.


#### Users container

`ldap_usercontainerrdn` is used to specify the RDN of the container of users in the directory base. e.g., if all users are inside the organisational unit represented by the DN `ou=Users,dc=domain,dc=tld`, then the users container RDN would be `ou=Users`.

```
ldap_usercontainerrdn="ou=Users"
```

This parameter is optional; there is not default value.

If the directory environment has a container for user objects then it is highly recommended to use this setting.


#### Groups container

`ldap_groupcontainerrdn` is used to specify the RDN of the container of groups in the directory base. e.g., if all groups are inside the organisational unit represented by the DN `ou=Groups,dc=domain,dc=tld`, then the users container RDN would be `ou=Groups`.

```
ldap_groupcontainerrdn="ou=Groups"
```

If not specified, then no separate DN for the group objects is formulated, but is mapped to the base DN of the directory.

If `ldap_groupname` (described earlier) is specified, and if the group objects are in a specific container (not in the directory base) then group container RDN should be specified here otherwise authentication will always fail.


#### LDAP version

`ldap_version` is used to specify version of the LDAP protocol used to communicate with the directory service. The possible choices PHP offers are either `2` or `3`.

```
ldap_version = 3
```

This is currently hard coded to be `3`.


#### Role based authorisation

*Xataface* offers role-based access for authenticated users. See *Xataface* documentation for more information.


##### Role column in database

`role_column` is used to specify field name of the column in the table containing the roles of the users.

```
role_column = "Role"
```


##### Default role

`default_role` is applied to directory authenticated users which are not found in the users table in the database.

```
default_role = "READ ONLY"
```

This action is performed by the module only once (or if the user was deleted from the users table in the database), as subsequent authentication loops will always find the user in the table.

If the user's permissions need to be changed, their role must be updated in the table, by whatever means are available through *Xataface*.


## Logic

*XatafaceLDAPauth* consists of the main `ldap.php` which controls the logic flow of the module and two discrete helper scripts

01. *phpLDAPauth* to interact with the directory service;
02. *phpDBauth* to interact with the database;

The authentication logic work flow is as follows:

01. User enters credentials on the *Xataface* login screen;
02. *Xataface* passes those credentials to `ldap.php`;
03. `ldap.php` passes those credentials first to *phpLDAPauth* in the request, along with the directory host and configuration;
04. *phpLDAPauth* uses these credentials to bind with the directory service, and check group membership if requested;
05. *phpLDAPauth* returns the result to `ldap.php`;
06. `ldap.php` then sends the authenticated users details to *phpDBauth* in a separate request, along with the database host and configuration;
07. *phpDBauth* looks up the user in the database table;
    1. If user is not found then it adds the user to the table and applies the default role (`default_role` role from *Xataface*'s `conf.ini`);
    2. If it finds the user then it takes no action in the database table;
08. *Xataface* takes over and logs the user into the application;
    1. Based on the role allocation (`ApplicationDelegate.php`), the user may or may not see the data; but is logged in nevertheless
    2. The username should be visible on the top right of the screen.

Access to data has to be managed through *Xataface*'s methods of permissions and authorisation and in the users table.


## Known limitations

Limitations of *XatafaceLDAPauth* are a combination of those of its [pre-requisites](#Pre-requisites)


## Support

For more information on installation, configuration and more additional options please refer to the documentation wiki.

For support on the *Xataface* authentication, please refer to the following *Xataface* documentation resource.

* http://xataface.com/wiki/LDAP_or_Active_Directory (primary *Xataface* LDAP documentation)
* http://xataface.com/documentation/tutorial/getting_started/permissions (more information about the `_auth` section of the `conf.ini` file)
* http://xataface.com/documentation/tutorial/getting_started/permissions (more information on *Xatafaces*'s role based permissions)
* http://weblite.ca/svn/dataface/modules/Auth/ldap/trunk/ (vanilla *Xataface* LDAP module with basic functionality)

Debugging can be enabled by setting boolean `$GLOBALS['bl_DebugSwitch']` to `TRUE`.

```
$GLOBALS['bl_DebugSwitch'] = TRUE ;
```

For all other issues, queries, suggestions and comments please create an [issue/ticket][ln_Issues].


## Contribute

Please feel free to clone/fork and contribute via pull requests. Donations also welcome, simply create an [issue/ticket][ln_Issues].

Please make contact for more information.


## Environment ##
Platform and software stack known to be compatible:

* Server OS
    * *Debian Wheezy*
    * *Debian Jessie*
    * *Ubuntu* 14.04
* Client OS
    * *Debian Wheezy*
    * *Debian Jessie*
    * *Windows* 7
* Web servers
    * *Apache* 2.2
    * *Apache* 2.4
* *PHP*
    * 5.4
    * 5.5
* Directory servers
    * *OpenLDAP* 2.4
    * *AD* (both *DS* and *LDS*) on *Windows* Server 2012


## License

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

See enclosed [`LICENSE`][ln_License] file.


## References


### Xataface LDAP module

* `ldap.php` version 0.1 (2008-05-20) from the *Xataface Web Application Framework*
* Licensed under the *GNU General Public License* version 2.
* Copyright (C) 2005-2008  *Steve Hannah* (shannah at sfu dot ca)
* Packaged in this project as `ldap-vanilla_0.1.php`


## Credits


### Tools


#### Kint

*Kint* debugging library (http://raveren.github.io/kint/), used under the MIT license

Copyright (c) 2013 Rokas Ã…Â leinius (raveren at gmail dot com)


### Utilities


#### Codiad

*Codiad* web based IDE (https://github.com/Codiad/Codiad), used under a MIT-style license.

Copyright (c) Codiad & Kent Safranski (codiad.com)


#### VS Code

*Visual Studio Code* code editor, used under the *Microsoft Software License*.


#### SmartGit

*SmartGit* client for *Git* (http://www.syntevo.com/smartgit/) used under SOFTWARE Non-Commercial License 

Copyright by syntevo GmbH


#### jEdit

*jEdit* text editor (http://www.jedit.org/), used under the GNU GPL v2.

Copyright (C) jEdit authors.


#### BitBucket

Hosted by *BitBucket* code repository (www.bitbucket.org).

Powered by *Atlassian* (www.atlassian.com).


### Testing

* Radoslav Chovan
* [David Gleba](http://github.com/dgleba) (AD development)



[mg_BadgeLicense]: https://img.shields.io/badge/license-mod--BSD-blue.svg?style=flat-square
[mg_BadgeVersion]: https://img.shields.io/badge/version-02.03.01-lightgrey.svg?style=flat-square
[mg_BadgeIssues]: https://img.shields.io/badge/issues----->-red.svg?style=flat-square
[mg_BadgeCodeLang]: https://img.shields.io/badge/language-php-yellowgreen.svg?style=flat-square
[ln_ReleaseLatest]: https://bitbucket.org/viharm/xatafaceldapauth/downloads
[ln_License]: LICENSE?at=master
[ln_Issues]: https://bitbucket.org/viharm/xatafaceldapauth/issues
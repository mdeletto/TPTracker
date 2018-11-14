# phpLDAPauth #

[![Version][mg_BadgeVersion]][ln_ReleaseLatest]
[![License][mg_BadgeLicense]][ln_License]
[![Issues][mg_BadgeIssues]][ln_Issues]
![Language][mg_BadgeCodeLang]

*phpLDAPauth* is a PHP library for authenticating with a LDAP server. It returns a true/false value for authentication if supplied with the correct parameters.


## Installation


### Pre-requisites

* PHP 5+ with LDAP support
* Standard web framework (web server, etc.)
* LDAP server


### Download


#### Archive

Get the release archives from [downloads][ln_ReleaseLatest]


#### Clone

Clone repository.

```
git clone --recurse-submodules \
https://bitbucket.org/viharm/phpldapauth.git
```

Remember to clone recursively (`--recurse-submodules`) to ensure cloning the submodules.


### Deploy

Extract the contents of the archive into the required directory. You should have a directory structure like the following:

* `<APPLICATION>/ldap/README.md`
* `<APPLICATION>/ldap/LICENSE.txt`
* `<APPLICATION>/ldap/VERSION.txt`
* `<APPLICATION>/ldap/phpldapauth.php`
* `<APPLICATION>/ldap/Lib/`
* `<APPLICATION>/ldap/Lib/fl_lib.inc.php`
* `<APPLICATION>/ldap/Lib/kint/`
* `<APPLICATION>/ldap/Lib/kint/...`


## Usage ##

This library requires a precise set of parameters supplied as associative arrays to work properly.

Use in your code by creating an object from the class and call the authentication method

```
$Dir = new cl_Dir($DirHost,$DirConf) ;
$AuthResult = $Dir->fn_Auth($Request) ;
```


### Input parameters/arguments ###

Directory settings variables in a pair of associative arrays of strings. The minimum configuration for a typical *OpenLDAP* installation on *Debian Wheezy* is shown in the example below


#### Directory host settings ####

```
$DirHost = array (
  'ky_Locn' => 'localhost' ,
  'ky_Port' => '389'
) ;
```

##### Host location #####

`$DirHost['ky_Locn']` specifies the location of the directory host.


##### Host port #####

`$DirHost['ky_Port']` specifies the port to connect to for accessing the directory service.


#### Directory configuration setings ####

```
$DirConf = array (
  'ky_LdapType'          => 'openldap ,
  'ky_LdapVer'           => 3 ,
  'ky_BaseDn'            => 'dc=domain,dc=tld',
  'ky_UsernameAttrib'    => 'uid' ,
  'ky_GroupnameAttrib'   => 'cn' ,
  'ky_GroupMemberAttrib' => 'memberuid' ,
  'ky_UserContainerRdn'  => 'ou=Users' ,
  'ky_GroupContainerRdn' => 'ou=Groups' ,
  'ar_GroupSearchFilter' => array (
    'objectClass=posixGroup' ,
    'objectClass=sambaGroupMapping'
  )
) ;
```

##### Directory type #####

`$DirConf['ky_LdapType']` specifies the type of the LDAP directory server.

This can be one of the following three types:

  *  `openldap`
  *  `ad-ds`
  *  `ad-lds`
  
This field is optional, the default value is `openldap`.


##### Directory base DN #####

`$DirConf['ky_BaseDn']` specifies the base DN of the directory tree.

In rare cases this can include the users container to authenticate users. But in this case `$DirConf['ky_UserContainerRdn']` should be left empty.

However such an approach will prevent checking group membership if the groups are in a different container to the users.

This field is required.


##### User name attribute #####

`$DirConf['ky_UsernameAttrib']` specifies the attribute name used by the directory to store the usernames.

This cannot be mapped to any field of choice, as this is used to formulate the DN of the user which will bind to the directory.

If the directory service supports binding by e-mail then this can be mapped to the appropriate `mail` field. 

This field is optional, the default value is `uid`.


###### User container RDN ######

`$DirConf['ky_UserContainerRdn']` specifies the RDN of the container used to store the users in the tree; e.g., `ou=Users`.

Although it is possible to include the users container in `$DirConf['ky_BaseDn']` described earlier, it is always good practice to keep them separate to allow additional functionality like group membership checking.

This field is optional, there is no default value.


##### Advanced usage #####

In addition to the above basic usage for user authentication the following configuration options allow additional features and usage.


##### LDAP protocol version

`$DirConf['ky_LdapVer']` specifies the LDAP protocol version to use with the directory server.

Version `3` is the current and the preferred version by most directory services.

This field is optional, the default value is `3`.


###### Group name attribute ######

`$DirConf['ky_GroupnameAttrib']` specifies the attribute name used by the directory to store the group name.

This is useful when it is desirable to authenticate a user only when they are members of a group.

This field is optional, the default value is `cn`.


###### Group member attribute ######

`$DirConf['ky_GroupMemberAttrib']` specifies the attribute name used by the directory to store the member usernames inside the group object.

This is useful when it is desirable to authenticate a user only when they are members of a group.

This field is optional, the default value is `memberuid`.


###### Group container RDN ######

`$DirConf['ky_GroupContainerRdn']` specifies the RDN of the container used to store the groups in the tree; e.g., `ou=Groups`.

If the users and the groups are in the same container in the directory tree (or in the base of the tree), then it is possible to specify the DN of that container in `$DirConf['ky_BaseDn']`.

Although it is possible to include the groups container in `$DirConf['ky_BaseDn']` described earlier, it is always good practice to keep them separate.

This parameter is optional, there is no default value.


###### Group search filters ######

If the directory structure is such that the groups are set up as non-standard objects then it is possible to over-ride the default group filters according to the environment.

`$DirConf['ar_GroupSearchFilter']` is a non-associative array of filters. Each array item is a filter criteria which is combined in `OR` logic by *phpLDAPauth* at runtime.

This parameter is optional. The default filter consists of the following `OR`d criteria:

*  `objectClass=posixGroup`
*  `objectClass=sambaGroupMapping`


#### Requests ####
Search requests are packaged in a 'Request' associative array of strings

```
$Request = array (
  'ky_UserKeyword'  => 'username' ,
  'ky_UserPassword' => 'password' ,
  'ky_UserDomain'   => 'userdomain' ,
  'ky_GroupKeyword' => 'usersgroup' ,
) ;
```


##### Username #####
`$Request['ky_UserKeyword']` specifies the username to be authenticated.

This username is used to formulate a DN which is used to bind with the directory for authentication.

This field is required.


##### Password #####
`$Request['ky_UserPassword']` specifies the password to be used with the username for authentication.

This is simply passed in plain text to the directory service.

This field is required.


##### User domain #####
`$Request['ky_UserDomain']` specifies the domain which the user belongs to.

This is required for Active Directory (both DS and LDS) servers.

This field is not required for OpenLDAP servers, so can be ignore; but it is required for AD DS and AD LDS directory servers (selected using `$DirConf['ky_LdapType']`), there is not default value. It is the deployer's responsbility to ensure a reasonable value is specified if the type of LDAP server selected requires this value.


##### Group #####

`$Request['ky_GroupKeyword']` specifies the group name to check user's membership.

This can be used to check if the user is member of a group.

This field is optional, there is no default value.


### Response ###

Function returns an associative array of three boolean elements

```
$Result = array (
  'ky_User_Authenticated' => FALSE,
  'ky_Group_Exists'       => FALSE,
  'ky_Group_ContainsUser' => FALSE,
) ;
```


#### User authentication ####

`$Result['ky_User_Authenticated']` is set to `TRUE` if the user specified in the request `$Request['ky_UserKeyword']` successfully binds to the directory.


#### Group existence ####

`$Result['ky_Group_Exists']` is set to `TRUE` if the group specified in the request `$Request['ky_GroupKeyword']` is found.

This is set irrespective of whether the authenticated user is a member of the group or not.

This is set to `FALSE` if the user is not authenticated.


#### Group membership ####

`$Result['ky_Group_ContainsUser']` is set to `TRUE` if the user specified in the request `$Request['ky_UserKeyword']` belongs to the group specified int he request `$Request['ky_GroupKeyword']`.

This is set to `FALSE` if the user is not authenticated.


## Known limitations ##

* No support for TLS connections to LDAP directories.
* No support for checking group membership for directories which store names of groups which the user belongs to within user objects.
  
  See https://samjlevy.com/use-php-and-ldap-to-get-a-users-group-membership-including-the-primary-group/ for such functionality.
* No support for editing directory entries


## Support

Debugging can be enabled by setting boolean `$GLOBALS['bl_DebugSwitch']` to `TRUE`.

```
$GLOBALS['bl_DebugSwitch'] = TRUE ;
```

For issues, queries, suggestions and comments please create an [issue/ticket][ln_Issues].


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


## License ##

Licensed under the modified BSD (3-clause) license.

A copy of the license is available...

* in the enclosed [`LICENSE`][ln_License] file.
* at http://opensource.org/licenses/BSD-3-Clause


## Credits


### Tools


#### Kint

*Kint* debugging library (http://raveren.github.io/kint/), used under the MIT license

Copyright (c) 2013 Rokas Å leinius (raveren at gmail dot com)


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
[mg_BadgeVersion]: https://img.shields.io/badge/version-02.03.00-lightgrey.svg?style=flat-square
[mg_BadgeIssues]: https://img.shields.io/badge/issues----->-red.svg?style=flat-square
[mg_BadgeCodeLang]: https://img.shields.io/badge/language-php-yellowgreen.svg?style=flat-square
[ln_ReleaseLatest]: https://bitbucket.org/viharm/phpldapauth/downloads
[ln_License]: LICENSE?at=master
[ln_Issues]: https://bitbucket.org/viharm/phpldapauth/issues
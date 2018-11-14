# phpDBauth

[![Version][mg_BadgeVersion]][ln_ReleaseLatest]
[![License][mg_BadgeLicense]][ln_License]
[![Issues][mg_BadgeIssues]][ln_Issues]
![Language][mg_BadgeCodeLang]

*phpDBauth* is a PHP library for looking up users in a database table field. It returns a boolean value if the user if found, if supplied with the correct parameters. If not found, the user is added to the same database table field; and a specified default role is applied to a specified role column in the same table.


## Installation


### Pre-requisites

* PHP 5+ with MySQL support (either `mysqli` or `mysql`)
* Standard web framework (web server, etc.)
* Database server (currently only MySQL is supported)


### Download


#### Archive

Get the release archives from [downloads][ln_ReleaseLatest]


#### Clone

Clone repository.

```
git clone --recurse-submodules \
https://viharm@bitbucket.org/viharm/phpdbauth.git
```

Remember to clone recursively (`--recurse-submodules`) to ensure cloning the submodules.


### Deploy

Extract the contents of the archive into the required directory. You should have a directory structure like the following:

* `<APPLICATION>/db/README.md`
* `<APPLICATION>/db/LICENSE.txt`
* `<APPLICATION>/db/VERSION.txt`
* `<APPLICATION>/db/phpdbauth.php`
* `<APPLICATION>/db/Lib/`
* `<APPLICATION>/db/Lib/fl_lib.inc.php`
* `<APPLICATION>/db/Lib/kint/`
* `<APPLICATION>/db/Lib/kint/...`


## Usage

This library requires a precise set of parameters supplied as associative arrays to work properly.

Use in your code by passing the correct parameters/arrays to the core function

```
$LookupResult = fn__Database_Verify (
  $Request ,
  $Table ,
  $MysqlExtension ,
  $Database ,
  $Database_Connection
) ;
```

### Input parameters/arguments


#### Request ####

Search requests are packaged in a 'Request' associative array of strings
```
$Request = array (
  'ky_UserKeyword' => 'username' ,
  'ky_UserPassword' => 'password' ,
  'ky_GroupKeyword' => 'usersgroup' ,
) ;
```


##### Username #####
`$Request['ky_UserKeyword']` specifies the username to be looked up.

This field is required.


##### Password #####
`$Request['ky_UserPassword']` is a password field for compatibility with other scripts.

This field is not required by the script and will be removed from future versions.

It is recommended that a `NULL` value be provided.


##### Group #####

`$Request['ky_GroupKeyword']` is a group field for compatibility with other scripts.

This field is not required by the script and will be removed from future versions.

It is recommended that a `NULL` value be provided.


#### Table settings

```
$Table = array (
  "key__Table_Name"             => "Users" ,
  "key__Table_ColumnUsername"   => "Username" ,
  "key__Table_ColumnRole"       => "Role" ,
  "key__Table_DefaultRoleValue" => "READ ONLY"
) ;
```

#### MySQL extension type

```
$MysqlExtension = 'mysqli' ;
```

```
$MysqlExtension = 'mysql' ;
```


#### Database parameters

```
$Database = array (
  "key__Database_Host"     => "localhost" ,
  "key__Database_Port"     => 3306 ,
  "key__Database_Name"     => "databasename" ,
  "key__Database_User"     => "databaseusername" ,
  "key__Database_Password" => "databasepassword" ,
) ;
```

#### Database connection object

```
$Database_Connection = $ExistingDb->Connection();
```

```
$ExistingDb->Connection = mysqli_connect (
  $Database [ "key__Database_Host" ] ,
  $Database [ "key__Database_User" ] ,
  $Database [ "key__Database_Password"] ,
  $Database [ "key__Database_Name" ] ,
  $Database [ "key__Database_Port" ]
) ;
```


### Response

The core function returns and associative array of three boolean elements.

```
$Result = array (
  "key__Database_Connection" => FALSE ,
  "key__Database_UserFound"  => FALSE ,
  "key__Database_UserAdded"  => FALSE
) ;
```


#### Database connection result

`$Result['key__Database_Connection']` is set to `TRUE` if the database connection (if required) was succesful.


#### User lookup

`$Result['key__Database_UserFound']` is set to `TRUE` if the requested user is found in the specified database table field.


#### User addition

`$Result['key__Database_UserAdded']` is set to `TRUE` if, following a failure to find him/her, the requested user was added to specified database table field.


## Known issues ##

* Currently there is no support for authentication;
* Currently there is only support for *MySQL* databases;


## Support

Debugging can be enabled by setting boolean `$GLOBALS['bl_DebugSwitch']` to `TRUE`.

```
$GLOBALS['bl_DebugSwitch'] = TRUE ;
```

For issues, queries, suggestions and comments please create an [issue/ticket][ln_Issues].


## Contribute

Please feel free to clone/fork and contribute via pull requests. Donations also welcome, simply create an [issue/ticket][ln_Issues].

Please make contact for more information.


## Development environment
Developed on..

* *Debian Wheezy*
* *Apache* 2.2
* *PHP* 5.4
* *MySQL* 5.4


## License

Licensed under the modified BSD (3-clause) license.

A copy of the license is available...

* in the enclosed [`LICENSE`][ln_License] file.
* at http://opensource.org/licenses/BSD-3-Clause


## Credits


### Tools


#### Kint

*Kint* debugging library (http://raveren.github.io/kint/). Licensed under the MIT license

Copyright (c) 2013 Rokas Šleinius (raveren at gmail dot com)


### Utilities


#### Codiad

*Codiad* web based IDE (https://github.com/Codiad/Codiad). Licensed under a MIT-style license.

Copyright (c) Codiad & Kent Safranski (codiad.com)


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



[mg_BadgeLicense]: https://img.shields.io/badge/license-mod--BSD-blue.svg?style=flat-square
[mg_BadgeVersion]: https://img.shields.io/badge/version-02.02.05-lightgrey.svg?style=flat-square
[mg_BadgeIssues]: https://img.shields.io/badge/issues----->-red.svg?style=flat-square
[mg_BadgeCodeLang]: https://img.shields.io/badge/language-php-yellowgreen.svg?style=flat-square
[ln_ReleaseLatest]: https://bitbucket.org/viharm/phpdbauth/downloads
[ln_License]: LICENSE?at=master
[ln_Issues]: https://bitbucket.org/viharm/phpdbauth/issues

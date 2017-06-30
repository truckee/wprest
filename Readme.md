wprest
======


**wprest** is a simple Symfony-based proxy RESTful API for testing the Remote Member Authentication WordPress plugin. The RMA plugin provides authorization to access restricted content in a WordPress website. When access to restricted content is attempted a sign in form is presented. Email and password credentials are directed to a URI and related settings established in the plugin.  

**wprest** can provide:

- Direct authentication of credentials without any administrative credentials. This may be useful for sites where both WordPress and the RESTful API are behind a firewall.
- HTTP Basic authentication with an admin set of credentials entered in the plugin's settings.
- API key authentication with an API key and key field name entered in the plugin's settings.

#### Database notes:

This application can only add entities through the command line. There are two tables in the MySQL database: member and user. Members are those to be authenticated by the RMA plugin. Users are the admin users capable of updating the member table. Members and users can only be created at the command line. See the notes below on [Creating users and members](#create). The application comes with a default user `admin` and two default members.

#### Installation

- Either clone or download & unpack zip file from github.
- In the __wprest__ directory run `composer install`
	- You will need to provide database definition paramters *host*, *database name*, *user* (with *select* and *update* privileges), and *password*. 
	- If you will be using API key authentication, enter your API key field name, e.g., *Api-key*.
- Run `$ php bin/console doctrine:database:create`
- Run `$ php bin/console doctrine:schema:create`
- Run `$ php bin/console doctrine:fixtures:load`

The __wprest__ database will contain the following test credentials:

- members: 
	- email = bborko@bogus.info
    	- password = 123Abc
    	- enabled = true
	- email =  developer@bogus.info
    	- password = empty string (for testing registration)
    	- enabled = true
	- email =  jglenshire@bogus.info
    	- password = 123Abc
    	- enabled = false
- user: (for HTTP Basic):
	- username: admin
	- password: 123Abc
- admin: (for API key authentication):
	- field name: Api-key
	- key: 3e2ec79352d2e9cbd76ad409d968ee435af6695c

#### <a name="create">Creating users and members</a>

__wprest__ includes the following console commands:

`$ php bin/console app:member:activate person@bogus.info`: To activate an existing member _person@bogus.info_

`$ php bin/console app:member:create newie@bogus.info 123Abc`: To create a new member _newie@bogus.info_ with password _123Abc_

`$ php app/console app:user:create newadmin newadmin@bogus.info 123Abc`: To create a new user with username _newadmin_, email _newadmin@bogus.info_, and password _123Abc_, i.e., a user with credentials like that provided by a real RESTful API. Note that this user does NOT immediately have admin privileges.  See the next command. **This command will return an API key**

`$ php bin/console fos:user:promote newadmin@bogus.info`: To add the role ROLE_ADMIN to the user _newadmin_

#### Testing:



- __Application__:The `.../test` directory contains a set of PHPUnit tests for the __wprest__ application. Tests can be run from the project command with a simple `phpunit` command (assuming PHPUnit is installed globally.) Note that the tests include SSL, so be sure to include a certificate (self-signed works) for the __wprest__ site.

- __Plugin__: The PHP internal web server can be used to launch __wprest__ but should not be used for SSL tests. The internal server does not support https requests. 

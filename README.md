wprest
======


**wprest** is a Symfony-based proxy RESTful API for testing the Remote Member Authentication WordPress plugin. The RMA plugin provides authorization to access restricted content in a WordPress website. When access to restricted content is attempted a sign in form is presented. Email and password credentials are directed to a URI and related settings established in the plugin.  

**wprest** can provide:

- Direct authentication of credentials without any administrative credentials. This may be useful for sites where both WordPress and the RESTful API are behind a firewall.
- HTTP Basic authentication with an admin set of credentials entered in the plugin's settings.
- API key authentication with an API key and key field name entered in the plugin's settings.

####Installation

- Either clone or composer require from github.
- In the __wprest__ directory run `composer install`
	- You will need to provide database definition paramters *host*, *database name*, *user* (with *select* and *update* privileges), *password*.
	- If you will be using API key authentication, enter your API key field name, e.g., *Api-key*.
- Run `$ php bin/console doctrine:create:database`
- Run `$ php bin/console doctrine:create:schema`
- Run `$ php bin/console doctrine:fixtures:load`

The __wprest__ database will contain the following test credentials:

- user (for member sign in): 
	- email = bborko@bogus.info
	- password = 123Abc
- admin: (for HTTP Basic):
	- username: admin
	- password: 123Abc
- admin: (for API key authentication):
	- field name: Api-key
	- key: ?





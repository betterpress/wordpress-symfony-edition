# Wordpress Symfony Edition

**Warning: This is pre-alpha, proof of concept stuff**

Wordpress, done the Symfony way.

Wordpress is a great, easy to use platform for content editing, but it's not without its flaws. This project aims to
fix some of those issues. It is inspired by and uses components from the symfony world and roughly matches the structure
of [`symfony/framework-standard-edition`](https://github.com/symfony/symfony-standard).

## Installation

`composer create-project betterpress/wordpress-symfony-edition --stability=dev`. You will be asked for database parameters - this
database must already exist and be accessible. 

Next setup your web server, with a document root of the folder `./wordpress`. Composer has created this folder for you. If you're 
just trying it out, you can run the PHP server locally (make sure you run from inside your project directory):

`php -S 0.0.0.0:8081 -t ./wordpress`

If the database details you have given are for an empty database, now visit your site and you should see the wordpress install screen. 
Follow these instructions, and you'll be ready to go. 

## Features

### True object-oriented wordpress manipulation

Sensible, well constructed, OO interface for managing wordpress wrapping all those function calls.

### Service container

All these nice interfaces for accessing wordpress features are accessible from the container, and injectable into your
own classes.

### Cleaner hooks

Tag a service in the container to run a hook, rather than `add_action` littered all over the place.


## Why not just...

### use wordpress plugins instead of bundles?

We're not saying don't use plugins at all. You still can. What we're saying is that if you're serious about delivering
a well thought out, reliable and maintainable system then bits of code which can " extend WordPress to do almost anything you can imagine"
should be added by a developer and go through whatever quality assurance processes you have, not be added through a web 
interface without thought or testing. 

We know from experience that one of the best ways to manage code in this way is through `composer`, and a symfony-like 
extension system which allows proper dependency injection makes for much more maintainable code. 

## Development

### Where are the tests?

Directly in this project, there aren't any. A lot of this code is experimental and not developed test-first. As it evolves 
and I get an idea of how the parts should interact, I extract them into separate repositories with proper tests. 
See [`betterpress/wordpress-adapter`](https://github.com/betterpress/wordpress-adapter) for example. 

### Structure

This section is more of a note and this is changing a lot. See `composer.json` for the current struture. 

Packages:

  - `adamquaile/php-global-abstraction`: Wrappers around PHP's features affecting global scope
  - `betterpress/wordpress-adapter`: Wrappers around the basic wordpress functions, e.g. hooks, global settings
  - `betterpress/wordpress-settings-api`: Wrappers around the Wordpress Settings API
  - `betterpress/wordpress-shortcode-api`: Wrappers around the Wordpress Settings API
  - `betterpress/wordpress-symfony-extension`: Extension to tie all the components together
      

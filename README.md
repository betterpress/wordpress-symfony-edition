# Wordpress Symfony Edition

**Warning: This is pre-alpha, proof of concept stuff**

Wordpress, done the Symfony way.

Wordpress is a great, easy to use platform for content editing, but it's not without its flaws. This project aims to
fix some of those issues. It is inspired by and uses components from the symfony world.

## Features

### True object-oriented wordpress manipulation

Sensible, well constructed, OO interface for managing wordpress wrapping all those function calls.

### Service container

All these nice interfaces for accessing wordpress features are accessible from the container, and injectable into your
own classes.

### Cleaner hooks

Tag a service in the container to run a hook, rather than `add_action` littered all over the place.

## Structure

Packages:
  - `php-global-abstraction`: Wrappers around PHP's features affecting global scope
  - `wordpress-adapter`: Wrappers around the basic wordpress functions, e.g. hooks, global settings
  - `wordpress-settings-api`: Wrappers around the Wordpress Settings API
  - `wordpress-symfony-extension`: Extension to tie all the components together
      
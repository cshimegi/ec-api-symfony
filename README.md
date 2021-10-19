# EC site microservices by Symfony

## Requirements
- ### PHP prettier
  - Because VScode prettier doesn't support php, need to install it additionally.
  - Installation
    ```bash
    $ npm install --global prettier @prettier/plugin-php
    ```
- ### PHP Packages
  - Installation
    ```bash
    $ cd /to/symfony/project/root
    $ composer install
    ```
- ### Symfony CLI
  - Installation (refer to [symfony official website](https://symfony.com/download))
    ```bash
    $ curl -sS https://get.symfony.com/cli/installer | bash
    ```

## Useful Commands
- ### Check supported commands
    ```
    $ make help
    ```
- ### Format all required php files
    ```bash
    $ cd /to/symfony/project/root
    $ make format-all
    ```
    For formatting all files under specific directory, please check corresponding command by help command.
- ### Run server
    ```bash
    $ make run-server
    ```
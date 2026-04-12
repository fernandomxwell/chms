## Contents
1. [Technology Stacks](#1-technology-stacks)
2. [Menu Creation Steps](#2-menu-creation-steps)
3. [Initial Deployment](#3-initial-deployment)
4. [Deployment Steps](#4-deployment-steps)

### 1. Technology Stacks
- PHP >= 8.2 (https://www.php.net/downloads.php)
- MySQL
- Composer 2.x (https://getcomposer.org/)
- Other server requirements (https://laravel.com/docs/12.x/deployment#server-requirements)

[**Back to contents**](#contents)

### 2. Menu Creation Steps
- Create new file in `app/Libraries/Menus`, set the filename based on menu's name
- Inside the file must contain the following details:
    - `getActions` public method that return the list of permissions of the menu
    - `getOrder` public method for sorting purposes
- Add the menu's name translation in `lang/` directory

[**Back to contents**](#contents)

### 3. Initial Deployment
- git clone
- Copy `.env.example` to `.env`, set it your own
- Run `composer install`
- Run `php artisan app:setup`

[**Back to contents**](#contents)

### 4. Deployment Steps
- git pull
- Run `composer install`
- Run `composer dump-autoload`
- Run `php artisan migrate`

[**Back to contents**](#contents)
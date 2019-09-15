GretaundStarks Test
========================

**WARNING**: This distribution is using symfony 3.4, INSTALLED IN PHP7.2

For details on how to download and get started with Symfony, see the
"Installation Steps" below

What's inside?
--------------

This Project is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

Steps to do before start aplication

  * Use "composer install" to setup everything

  * Configure database settings in app/config/parameters.yml file

  * Use "php bin/console doctrine:database:create" to create the database

  * Use "php bin/console doctrine:schema:update --force" to create the tables

  * start the server using "php bin/console server:run"

Available APIs

  * GET - /api/init

  * GET - /api/index (optional parameters ?limit=<INT>&offset=<INT>&sort=<ASC/DESC>&filter=<any value>)

  * GET - /api/entry?id=<movie_id>

  * DELETE - /api/entry?id=<movie_id>
Tests
  * Run "vendor/bin/simple-phpunit"
  
Improvements

  * Validation need to be implemented for real usage

  * Test cases need to be improvize with more test scenarios



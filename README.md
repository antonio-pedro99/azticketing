# Azticketing

A robust ticketing system for your Laravel application using Azure Board.

## Motivation

I created this package to help developers integrate Azure Board into their Laravel applications. This package is designed to be simple and easy to use.

## Installation

1. You can install the package via composer:

```bash
composer require antonio-pedro99/azticketing
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="AntonioPedro\Azticketing\AzticketingServiceProvider" --tag="azticketing-config"
```

## Configuration

You can configure the package by editing the `config/azticketing.php` file. It contains the following options:

```php
organization: Your Azure DevOps organization.
project: Your Azure DevOps project.
pat: Personal Access Token for Azure DevOps.
webhook_secret: Secret for validating incoming webhooks.
area_path: Area path for the tickets.
app: Configuration for the Laravel application. You can set the following options:
    page_title: Default page title.
    url: The URL of the application.
    version: The version of the application.
enable_views: Enable or disable the default views for manager tickets.
routes: Configuration for the default routes. You can set the following options:
    prefix: The prefix for the routes.
    middleware: The middleware for the routes.
```

## Exemple of usage

### Creating a Ticket

You can create a ticket using the `createTicket` method:

```php
use use AzTicketingManager;

AzTicketingManager::createTicket(
    'My first ticket',
    'This is the description of my first ticket.', []);
```

The empty array at the end is for metadata or customs fields. You can pass tags, priority, and other fields.

## Contributing

If you would like to contribute to this package, please feel free to submit a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

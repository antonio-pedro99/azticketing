# Azticketing

Report bugs and more from your Laravel application to Azure DevOps Boards.

## Motivation

This package was created to help developers integrate Azure Board into their Laravel applications in order to add ticketing support for their users. This package is designed to be simple and easy to use.

## Installation

1. You can install the package via repository:

On your `composer.json` file, add the following repository:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/antonio-pedro99/azticketing"
    }
]
```

Then, run the following command:

```bash
composer update
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --tag="azticketing-config"
```

## Configuration

You can configure the package by editing the `config/azticketing.php` file. It contains the following options:

```php
"organization": // Your Azure DevOps organization.
"project": // Your Azure DevOps project.
"pat": //Personal Access Token for Azure DevOps.
"webhook_secret": //Secret for validating incoming webhooks. Ignore for now
"area_path": // Area path for the tickets. If not set, it will use the project name.
"app:" //Configuration for the Laravel application. You can set the following options:
    "page_title": // Default page title.
"enable_views": // Enable or disable the default views for manager tickets.
"routes": // Configuration for the default routes. You can set the following options:
    "prefix": // The prefix for the routes.
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

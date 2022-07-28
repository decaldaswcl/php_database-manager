# About

PHP_Database-Manager Set of SQL language commands that are used to retrieve, add, remove and modify information within a database.

# Requeriments

PHP_Database-Manager requires PHP version 7.3 or greater. 

# Installation
#### Composer
If you use Composer, you can install PHP_DatabaseManager system-wide with the following command:
```bash
composer global require "decaldaswcl/PHP_database-manager"
```
Or alternatively, include a dependency for decaldaswcl/PHP_database-manager in your composer.json file. For example:

```json
{
    "require-dev": {
        "decaldaswcl/PHP_database-manager": "1.0.*"
    }
}
```

# Getting Started

How to include the class in your project

```php
<?php

require 'vendor/autoload.php';

use decaldaswcl\DatabaseManager\Database;
```

Configuring the class and instantiating

```php
Database::config('LocalHost','dataBase','user','pass','port');

$object = new Database('tableName');
```

# Using the functions

- Select responsible for executing a query in the database

return object of type PDOStatement

```php
$results = $obDatabase->select('id < 5 ');
```

- Insert responsible for inserting data into the database

return inserted id

```php
$id = $obDatabase->insert([
  'name' => 'Isac'
]);
```

- Update responsible for performing updates on the database

return a boolean value

```php
$boolean = $obDatabase->update('id = 1',[
  'age' => '30'
]);
```

- Delete responsible for deleting database data

return a boolean value

```php
$success = $obDatabase->delete('id = 1');
```


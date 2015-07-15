Accounts management module
==========================

Installation
------------

```bash
composer require cookyii/module-account:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config 
in section `modules` add `cookyii\modules\Account\backend\Module`
and in section `bootstrap` add `account`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'account'
    ],
    'modules' => [
        // some modules ...
        'account' => 'cookyii\modules\Account\backend\Module',
    ],
    // ...
];
```

### 2. Dependencies
Also, you need to configure the following modules (they are already downloaded):

* [`cookyii/module-postman`](https://github.com/cookyii/module-postman)

```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'account', 'postman',
    ],
    'modules' => [
        // some modules ...
        'account' => 'cookyii\modules\Account\backend\Module',
        'postman' => 'cookyii\modules\Postman\backend\Module',
    ],
    // ...
];
```

### 3. Add new permissions
In `rbac/update` command add "merge" class `cookyii\modules\Account\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Account\backend\Permissions',
        'cookyii\modules\Postman\backend\Permissions',
    ];
    
    // ...
}

```

### 4. Update permissions
```bash
./backend rbac/update
```

### 5. Execute new migrations
```bash
./frontend migrate
```

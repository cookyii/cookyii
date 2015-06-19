Accounts management module
=========================

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

### 2. Add new permissions
In `rbac/update` command add "merge" class `cookyii\modules\Account\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Account\backend\Permissions',
    ];
    
    // ...
}

```

### 3. Update permissions
```bash
./backend rbac/update
```

### 4. Execute new migrations
```bash
./frontend migrate
```

Clients management module
=========================

Installation
------------

```bash
composer require cookyii/module-client:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config 
in section `modules` add `cookyii\modules\Client\backend\Module`
and in section `bootstrap` add `client`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'client'
    ],
    'modules' => [
        // some modules ...
        'client' => 'cookyii\modules\Client\backend\Module',
    ],
    // ...
];
```

### 2. Add new permissions
In `rbac/update` command add "merge" class `cookyii\modules\Client\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Client\backend\Permissions',
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

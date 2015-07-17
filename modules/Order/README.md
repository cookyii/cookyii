Orders management module
========================

Installation
------------

```bash
composer require cookyii/module-order:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config 
in section `modules` add `cookyii\modules\Order\backend\Module`
and in section `bootstrap` add `order`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'order'
    ],
    'modules' => [
        // some modules ...
        'order' => 'cookyii\modules\Order\backend\Module',
    ],
    // ...
];
```

### 2. Add new permissions
In `rbac/update` command add "merge" class `cookyii\modules\Order\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Order\backend\Permissions',
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

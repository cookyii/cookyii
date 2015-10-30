Translation management module
=============================

Installation
------------

```bash
composer require cookyii/module-translation:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config
in section `modules` add `cookyii\modules\Translation\backend\Module`
and in section `bootstrap` add `page`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'translation'
    ],
    'modules' => [
        // some modules ...
        'translation' => 'cookyii\modules\Translation\backend\Module',
    ],
    // ...
];
```

### 2. Add new permissions
In `rbac/update` command add merge class `cookyii\modules\Translation\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Translation\backend\Permissions',
    ];
}

```

### 4. Update permissions
```bash
./backend rbac/update
```

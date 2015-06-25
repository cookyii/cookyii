Module for organization feeds
=============================

Installation
------------

```bash
composer require cookyii/module-feed:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config 
in section `modules` add `cookyii\modules\Feed\backend\Module`
and in section `bootstrap` add `feed`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'feed'
    ],
    'modules' => [
        // some modules ...
        'feed' => 'cookyii\modules\Feed\backend\Module',
    ],
    // ...
];
```

### 2. Dependencies
Also, you need to configure the following modules (they are already downloaded):

* [`cookyii/module-media`](https://github.com/cookyii/module-media).

```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'feed', 'media'',
    ],
    'modules' => [
        // some modules ...
        'feed' => 'cookyii\modules\Feed\backend\Module',
        'media' => 'cookyii\modules\Media\backend\Module',
    ],
    // ...
];
```

### 3. Add new permissions
In `rbac/update` command add "merge" class `cookyii\modules\Feed\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Feed\backend\Permissions',
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

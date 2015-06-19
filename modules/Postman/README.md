Emails management module
========================

Installation
------------

```bash
composer require cookyii/module-postman:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config
in section `modules` add `cookyii\modules\Postman\backend\Module`
and in section `bootstrap` add `page`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'postman'
    ],
    'modules' => [
        // some modules ...
        'postman' => 'cookyii\modules\Postman\backend\Module',
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
        'postman', 'media',
    ],
    'modules' => [
        // some modules ...
        'postman' => 'cookyii\modules\Postman\backend\Module',
        'media' => 'cookyii\modules\Media\backend\Module',
    ],
    // ...
];
```

### 3. Add new permissions
In `rbac/update` command add merge class `cookyii\modules\Page\backend\Permissions`:
```php
// ./common/commands/RbacCommand.php

class RbacCommand extends \rmrevin\yii\rbac\Command
{
    
    public $backendMerge = [
        // ...
        'cookyii\modules\Postman\backend\Permissions',
    ];
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

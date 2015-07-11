Pages management module
=======================

Installation
------------

```bash
composer require cookyii/module-page:dev-master
```

Configuration
-------------

### 1. Update config
In `backend` `app` config
in section `modules` add `cookyii\modules\Page\backend\Module`
and in section `bootstrap` add `page`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'page'
    ],
    'modules' => [
        // some modules ...
        'page' => 'cookyii\modules\Page\backend\Module',
    ],
    // ...
];
```

In `frontend` `app` config
in section `modules` add `cookyii\modules\Page\frontend\Module`
and in section `bootstrap` add `page`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'page'
    ],
    'modules' => [
        // some modules ...
        'page' => 'cookyii\modules\Page\frontend\Module',
    ],
    // ...
];
```

### 2. Dependencies
Also, you need to configure the following modules (they are already downloaded):

* [`cookyii/module-account`](https://github.com/cookyii/module-account)
* [`cookyii/module-postman`](https://github.com/cookyii/module-postman)
* [`cookyii/module-media`](https://github.com/cookyii/module-media)

```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'account', 'page', 'postman', 'media',
    ],
    'modules' => [
        // some modules ...
        'account' => 'cookyii\modules\Account\backend\Module',
        'page' => 'cookyii\modules\Page\backend\Module',
        'postman' => 'cookyii\modules\Postman\backend\Module',
        'media' => 'cookyii\modules\Media\backend\Module',
    ],
    // ...
];
```

```php
// ./frontend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'page', 'media',
    ],
    'modules' => [
        // some modules ...
        'page' => 'cookyii\modules\Page\frontend\Module',
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
        'cookyii\modules\Account\backend\Permissions',
        'cookyii\modules\Page\backend\Permissions',
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

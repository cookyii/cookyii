Media management module
=======================

Installation
------------

```bash
composer require cookyii/module-media:dev-master
```

Configuration
-------------

### 1. Update config
In all `app's` config 
in section `modules` add `cookyii\modules\Media\Module`
and in section `bootstrap` add `media`:
```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'media'
    ],
    'modules' => [
        // some modules ...
        'media' => 'cookyii\modules\Media\Module',
    ],
    // ...
];
```

### 2. Dependencies
Also, you need to configure the module [account](https://github.com/cookyii/module-account) (it is already downloaded).

```php
// ./backend-app/config/app.php

return [
    // ...
    'bootstrap' => [
        // some components ...
        'account', 'media',
    ],
    'modules' => [
        // some modules ...
        'account' => 'cookyii\modules\Account\backend\Module',
        'media' => 'cookyii\modules\Media\backend\Module',
    ],
    // ...
];
```

### 3. Execute new migrations
```bash
./frontend migrate
```

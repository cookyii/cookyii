Installation
------------

```bash
composer require cookyii/module-account:dev-master
```

After downloading in `backend` config in section `bootstrap` add:
```php
return [
    // ...
    'bootstrap' => [
        // some components ...
        'cookyii\modules\Account\backend\Bootstrap'
    ],
    // ...
];
```
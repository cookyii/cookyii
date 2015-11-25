Каркас проекта Cookie CMF
=========================

`cookyii/project` это каркас приложения [Yii 2](http://www.yiiframework.com/)
оптимизированный под горизонтальное масштабирование приложения.

Каркас включает базовые функции для работы cms,
а также предоставляет инфраструктуру для работы готовых модулей,
реализующий ту или иную функциональность.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)


Структура директорий
--------------------

На данный момент в шаблоне представлено три приложения - `frontend`, `backend` и `crm`.
Это всего лишь пример набоа приложений.
Можно смело удалять любые приложения, либо создавать свои собственные.

    conf.d/                 файлы конфигурации для окружения (например nginx или rabbitmq)
    common/                 общие компоненты для всех приложений
    frontend-app/           общий код приложения frontend
    frontend-assets/        assets для приложения frontend
    frontend-modules/       модули приложения frontend
    backend-app/            общий код приложения backend
    backend-assets/         assets для приложения backend
    backend-modules/        модули приложения backend
    crm-app/                общий код приложения crm
    crm-assets/             assets для приложения crm
    crm-modules/            модули приложения crm
    messages/               переводы приложений для всех приложений
    resources/              общие ресурсы (модели) для всех приложений
    vendor/                 пакеты сторонних разработчиков



### Структура директорий внутри проложения

    frontend-assets/        исходники ресурсов, которые будут опубликованны в публичной части приложения
    frontend-app/
        assets/             ресурсы для внешнего вида приложения
        components/         общие компоненты приложения
        config/             конфигурация приложения
        controllers/        базовые контроллеры приложения
        tests/              автоматические тесты приложения
        views/              общие представления (view) прилоения
        web/                публичная часть приложения, доступная из веба
        widgets/            общие виджеты приложения
        


### Структура директорий внутри модуля

    frontend-modules/
        ModuleName/
            assets/             ресурсы для внешнего вида модуля
            commands/           контроллеры команды для выполнения в терминале (cli)
            components/         компоненты модуля
            controllers/        контроллеры модуля
            views/              представления (view) модуля
            widgets/            виджеты модуля



Системные требования
--------------------

Минимальным требованием для работы этого каркаса является наличие PHP 5.4.0 или выше.


Установка
---------

Для начала необходимо установить `nodejs`, `npm` и `gulp`.

* [Установка ноды и `npm`](https://github.com/joyent/node/wiki/Installation).
* [Установка `gulp`](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md).

Если у Вас не установлен [Composer](http://getcomposer.org/), вы должны установить его.
Информацию об этом Вы можете получить на сайте [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

### Установка через `composer`

Установить этот шаблон проекта Вы можете выполнив следующую команду:

```bash
composer global require "fxp/composer-asset-plugin:~1.1.0"
composer create-project --prefer-dist --stability=dev cookyii/project new-project
```

Далее Вам следует настроить виртуальные хосты Вашего Web сервера на следующие директории:

```
www.new-project.com     ->  .../frontend-app/web
backend.new-project.com ->  .../backend-app/web
crm.new-project.com     ->  .../crm-app/web
```


Развертывание нового проекта (deploy)
-------------------------------------

1. Скопировать файл `.env.dist.php` в `.env.php` (в базовой директории), заполнить необходимые данные.
2. Скопировать файлы `.credentials.dist.php` в `.credentials.php` (в директориях приложений), заполнить необходимые данные.
3. Собрать билд с помощью команды `./build` (для продакшена `./build env/prod`).


Настройка
---------

Вы можете изменять любые настройки в директориях `./common/config/`, `./frontend-app/config/`, `./backend-app/config/`, `./crm-app/config/` и в конфигурации билда проекта.


Доступные команды `./build`
---------------------------

* `./build` или `./build env/dev` - собрать проект для dev площадки.
* `./build env/demo` - собрать проект для demo площадки.
* `./build env/production` - собрать проект для продакшена.

Дополнительно доступны следующие команды (они выполняются в рамках `set/*` команд, и сюда добавлены только для справки):
* `./build map` - показать список всех команд.
* `./build clear` - удалить все временные файлы и логи во всех приложениях.
* `./build clear/*` - удалить все временные файлы и логи в конкретном приложении.
* `./build composer` - установить `composer` зависимости из `composer.lock`.
* `./build composer/update` - скачать новые версии `composer` зависимостей и обновить `composer.lock`.
* `./build composer/install` - скачать новые версии `composer` зафиксированные в `composer.lock`.
* `./build composer/install-prod` - скачать новые версии `composer` зафиксированные в `composer.lock` без `require-dev`.
* `./build composer/selfupdate` - обновить `composer`.
* `./build composer/update-fxp` - обновить плагин `fxp/composer-asset-plugin`.
* `./build npm/install` - установить зависимости `npm`.
* `./build npm/update` - обновить зависимости `npm`.
* `./build bower/install` - установить зависимости `bower`.
* `./build bower/update` - обновить зависимости `bower`.
* `./build migrate` - выполнить все новые миграции для всех приложений.
* `./build migrate/*` - выполнить все новые миграции для конкретного приложения.
* `./build rbac` - обновить правила `rbac` для всех приложений.
* `./build rbac/*` - обновить правила `rbac` для конкретного приложения.
* `./build less` - скомпилировать `less` для всех приложений.
* `./build less/*` - скомпилировать `less` для конкретного приложения.
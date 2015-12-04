Каркас проекта Cookie CMF
=========================

`cookyii/project` это каркас приложения [Yii 2](http://www.yiiframework.com/)
оптимизированный под средние и большие проекты, которые состоят из нескольких приложений
(как правило - админа + публичный сайт, но могут добавляться и другие виды.
Например rest, erp, crm, мобильное приложение и тд).

Каркас включает базовые функции для работы cms,
а также предоставляет инфраструктуру для работы готовых модулей,
реализующий ту или иную функциональность.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)


Структура директорий
--------------------

На данный момент в шаблоне представлено три приложения - `frontend`, `backend` и `crm`.
Это всего лишь пример набора приложений.
Можно смело удалять любые приложения, либо создавать свои собственные.

    conf.d/                 файлы конфигурации для окружения (например nginx или rabbitmq)
    common/                 общие компоненты для всех приложений
    frontend-app/           код приложения frontend
    frontend-assets/        ресурсы для приложения frontend
    frontend-modules/       модули приложения frontend
    backend-app/            код приложения backend
    backend-assets/         ресурсы для приложения backend
    backend-modules/        модули приложения backend
    crm-app/                код приложения crm
    crm-assets/             ресурсы для приложения crm
    crm-modules/            модули приложения crm
    messages/               переводы языковых строк для всех приложений
    resources/              модели ActiveRecord для всех приложений
    vendor/                 пакеты сторонних разработчиков



### Структура директорий внутри проиложения

    frontend-assets/        исходники ресурсов, которые будут опубликованны в публичной части приложения
    frontend-app/
        assets/             бандлы с ресурсами приложения
        components/         компоненты приложения
        config/             конфигурация приложения
        controllers/        контроллеры приложения
        tests/              автоматические тесты приложения
        views/              представления (view) приложения
        web/                публичная часть приложения, доступная из веба
        widgets/            виджеты приложения
        


### Структура директорий внутри модуля

    frontend-modules/
        ModuleName/
            assets/             ресурсы и бандлы для модуля
            commands/           контроллеры команд для выполнения в терминале (cli)
            components/         компоненты модуля
            controllers/        контроллеры модуля
            views/              представления (view) модуля
            widgets/            виджеты модуля



Системные требования
--------------------

* [PHP 5.4](http://php.net) или выше
* [NodeJS 0.10](https://nodejs.org/en/) или выше
* [Composer](http://getcomposer.org/)
* [npm](https://docs.npmjs.com/getting-started/installing-node)


Установка
---------

Установить этот шаблон проекта Вы можете выполнив следующие команды:

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


Развертывание нового проекта (first deploy)
-------------------------------------------

1. Запустить процес инсталяции с помощью команды `./build install`. Скрипт задаст несколько вопросов и выполнит следующие действия:
   * Создаст новую схему в базе данных (`install/database`)
   * Создаст нового пользователя и даст ему права на доступ к этой базе данных (`install/mysqlUserName`)
   * Скопирует файл `.env.dist.php` в `.env.php` и заполнит некоторые поля автоматически.
2. Проверить, что в созданном файле конфигурации `.env.php` заполнены все необходимые поля.
3. Скопировать файлы `~/*-app/.credentials.dist.php` в `~/*-app/.credentials.php` (в директориях приложений), заполнить необходимые данные.
4. Собрать билд с помощью команды `./build` (для продакшена `./build prod`).
5. Создать нового пользователя - администратора с помощью команды `./yii account/add`

Обновление проекта (deploy)
---------------------------

1. Обновить кодовую базу проекта выполнив команду `git pull`.
2. Собрать билд с помощью команды `./build` (для продакшена `./build prod`).

Настройка
---------

Вы можете изменять любые настройки в директориях
`./common/config/`, `./frontend-app/config/`, `./backend-app/config/`, `./crm-app/config/`, `./console-app/config/`
и в конфигурации билда проекта.


Доступные команды `./build`
---------------------------

* `./build install` - запустить процесс установки.
* `./build` или `./build dev` - собрать проект для dev площадки.
* `./build demo` - собрать проект для demo площадки.
* `./build prod` - собрать проект для продакшена.

Дополнительно доступны следующие команды (они выполняются в рамках `set/*` команд, и сюда добавлены только для справки):
* `./build map` - показать список всех команд.
* `./build self/update` - обновить библиотеку сборки `build.phar`.
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
# Каркас Cookie CMF

## Подготовка окружения

Для начала необходимо установить `nodejs` и `npm`. Установка описана на [GitHub](https://github.com/joyent/node/wiki/Installation).

Для обработки bower пакетов, в системе требуется глобально установить пакет `fxp/composer-asset-plugin`. Делается это командой
```
php composer.phar global require "fxp/composer-asset-plugin:1.0.0"
```
Для полуавтоматического деплоя используется phing. Установить phing не составляет труда. Для этого необходимо выполнить команду
```bash
pear channel-discover pear.phing.info
pear install --alldeps phing/phing
```

## Деплой

Document root -
* Web - `~/web-app/web`
* Backend - `~/backend-app/web`
* CRM - `~/crm-app/web`
* etc.

1. Клонировать проект через git.
2. Скопировать файл `.environment.example.php` в `.environment.php`, заполнить необходимые данные. DB_* - основаня база, DB_TEST_* - копия базы для автоматических тестов.
3. Скопировать файл `.credentials.example.php` в `.credentials.php`, заполнить необходимые данные.
4. Установить зависимости через композер `./composer.phar install --prefer-dist` (если нет композера, установить через `./getcomposer`).
5. С помощью команды `./init` выбрать нужное окружение.
6. Развернуть миграции `./web migrate`, `./backend migrate`, `./crm migrate`.
7. Установить frontend зависимости через npm `npm install`.
8. Скомпилировать assets в css `phing assets`.
9. Создать пользователя-администратора `./web user/add`.

Система готова к эксплуатации.

## Обновление

1. Обновить кодовую базу через git
2. Обновить композер `./composer.phar selfupdate`
3. Обновить зависимости через композер `./composer.phar install --prefer-dist`
4. Развернуть новые миграции `./web migrate`, `./backend migrate`, `./crm migrate`.
5. Оновить frontend зависимости через npm `npm update`
6. Скомпилировать assets в css `phing assets`.

Система готова к эксплуатации.

## Полуавтоматический деплой и обновление

Сначала потребуется скачать обновление из гита командой `git pull`, затем выполнить одну из команд:
* `phing build/production` - собрать проект для продакшена.
* `phing build/demo` - собрать проект для demo площадки.
* `phing build/dev` - собрать проект для dev площадки.

Дополнительно доступны следующие команды (они выполняются в рамках `build/*` команд, и сюда добавлены только для справки):
* `phing clear` - удалить все временные файлы и логи во всех приложениях.
* `phing clear/*` - удалить все временные файлы и логи в конкретном приложении.
* `phing migrate` - выполнить все новые миграции для всех приложений.
* `phing migrate/*` - выполнить все новые миграции для конкретного приложения.
* `phing assets` - скомпилировать assets для всех приложений.
* `phing assets/*` - скомпилировать assets для конкретного приложения.
* `phing composer` - установить composer зависимости из composer.lock.
* `phing composer/update` - скачать новые версии composer зависимостей и обновить composer.lock.
* `phing rbac` - обновить правила rbac для всех приложений.
* `phing rbac/*` - обновить правила rbac для конкретного приложения.

## Основные моменты

За основу каркаса взят yii2-advance-application. Он позволяет создавать комплекс из разных приложений с разными подходами (обычное web приложение, cli приложение, rest приложение).
На данный момент, в проекте созданны следующие приложения:
* web-app - основное web приложение.
* backend-app - приложение для панели управления.
* crm-app - приложение для crm системы.

Так же присутствуют несколько вспомогательных разделов:
* common - общие для всех приложений ресурсы (конфиги, расширяющие компоненты фреймворка, хелперы и тд)
* web-modules - модули для web приложения.
* backend-modules - модули для backend приложения.
* crm-modules - модули для crm приложения.

## Для запуска тестов

Для того, чтобы запустить codeception тесты, необходимо скопировать конфигурации для тестов и настроить их для своей плащадки.

Автоматически, это поможет сделать `phing`. Запускаете из корня проекта команду `phing codecept`, и конфиги автоматически скопируются.

Для ручного копирования необходимо в директориях `web-app/tests`, `backend-app/tests` и `crm-app/tests`
скопировать файлы `acceptance.suite.yml.dist` в `acceptance.suite.yml`, `functional.suite.yml.dist` в `functional.suite.yml`
и `unit.suite.yml.dist` в `unit.suite.yml`.

Остальные файлы могут быть оставлены без изменений.

После создания конфигов, нужно "собрать" "актёров" для тестирования. Для этого из корня проекта выполните команды
```bash
./codecept build -c web-app/tests/codeception.yml
./codecept build -c backend-app/tests/codeception.yml
./codecept build -c crm-app/tests/codeception.yml
```
Теперь можно приступать непосредственно к запуску тестов.

Для этого из корня провека выполните команду
```bash
# запустить выполнение всех тестов во всех приложениях
./codecept run

# запустить выполнение только тестов для erp приложения
./codecept run -c web-app/tests/codeception.yml

# запустить выполнение только unit тестов для hub приложения
./codecept run -c web-app/tests/codeception.yml unit

# запустить выполнение определённого unit теста для hub приложения
./codecept run -c web-app/tests/codeception.yml unit commands/UserCommandTest.php
```

Для генерации карты покрытия кода к вызову комманды добавьте параметр --coverage-html.
Для отображения более подробной иформации по ходу выполнения теста к вызову комманды добавьте параметр --debug.
```bash
./codecept run --coverage-html
./codecept run -c web-app/tests/codeception.yml --coverage-html --debug
```
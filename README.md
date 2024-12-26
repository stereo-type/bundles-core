# Пакет для ядра системы проектов на Symfony. Содержит хелперы для работы проекта

## Руководство разработчика

### 1. Системные требования

- PHP >= 8.2
- Symfony >= 7.1

### 2. Установка

- в основном проекте в composer.json прописать
  ```
  "repositories": [
        {
            "type": "vcs",
            "url": "https://oauth2:JRB8vueyHk5JnBfUjNsb@gitlab.dev-u.ru/bundles/core_bundle.git"
        }
  ]
  ```
- выполнить команду `composer require academcity/core_bundle`, желательно указать последнюю версию при установке,
  пример `composer require academcity/core_bundle 1.3.5`
- отчистить кеш `php bin/console cache:clear`

### 3. ISSUSES

после установки бандла произойдет копирование config/packages/academ_city_core.yaml в основной проект,
копирование видимо происходит ассинхронно, несмотря на вызов перед загрузкой конфигов, поэтому может быть получена
ошибка ` The child config "user_class" under "academ_city_core" must be configured.`
Повторное выполнение отчистки кеша решит проблему `php bin/console cache:clear`

### Команды

- `make php-stan`  - `vendor/bin/phpstan analyse src tests`
- `make php-fix`  -  `vendor/bin/php-cs-fixer fix src && vendor/bin/php-cs-fixer fix tests`

### PS

*Редакция от 10/12/2024*

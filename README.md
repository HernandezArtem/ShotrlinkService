# ShortLink

Веб-приложение для создания коротких ссылок с отслеживанием переходов и личным кабинетом пользователя.

## Описание

Сервис позволяет зарегистрированному пользователю сократить длинный URL и получить короткую ссылку вида `http://yourdomain/abc123`. При переходе по короткой ссылке выполняется редирект на оригинальный адрес, а переход фиксируется в статистике. Управление ссылками и просмотр аналитики доступны в личном кабинете на базе **Filament v3**.

## Технологии

- **PHP** 8.1+
- **Laravel** 10
- **Filament** 3 (личный кабинет)
- **SQLite** (по умолчанию) / MySQL (опционально)

## Соответствие ТЗ

| Требование | Реализация |
|------------|------------|
| Регистрация и вход | `/admin/register`, `/admin/login` |
| Создание короткой ссылки | Главная `/` и кабинет `/admin` |
| Редирект по короткому коду | `GET /{code}` |
| Фиксация перехода | Таблица `clicks` |
| Список своих ссылок | Filament → «Мои ссылки» |
| Удаление ссылки | Кнопка «Удалить» в кабинете |
| Статистика по ссылке | Страница «Статистика» + список переходов |
| IP-адрес перехода | Поле `ip_address` |
| Дата и время перехода | Поле `clicked_at` |
| Общее количество кликов | Счётчик в таблице и на дашборде |
| Личный кабинет на Filament v3 | `/admin` |

## Требования

- PHP 8.1 или выше
- Composer
- Расширения PHP: `openssl`, `pdo_sqlite`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `intl`, `zip`, `fileinfo`

Рекомендуется использовать [Laragon](https://laragon.org/) на Windows — в нём уже есть PHP, Composer и удобный терминал.

## Установка

### 1. Клонировать / скопировать проект

```bash
cd D:\yourdirect\yourdirect 
```

> Если проект лежит в другой папке — укажите свой путь.

### 2. Настроить PHP и Composer (Windows / Laragon)

В **Laragon Terminal** (cmd, промпт `λ`) или PowerShell, если `php` / `composer` не находятся:

**cmd (Laragon Terminal):**
```cmd
set PATH=D:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;D:\laragon\bin\composer;%PATH%
```

**PowerShell:**
```powershell
$env:Path = "D:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;D:\laragon\bin\composer;" + $env:Path
```

> Версию PHP смотрите в `D:\laragon\bin\php\`. В `php.ini` должно быть включено расширение `extension=zip`.

### 3. Установить зависимости

```bash
composer install
```

### 4. Настроить окружение

```bash
copy .env.example .env
php artisan key:generate
```

### 5. Подготовить базу данных

По умолчанию используется SQLite. Создайте файл БД (его нет в репозитории):

**cmd:**
```cmd
type nul > database\database.sqlite
```

**PowerShell:**
```powershell
New-Item database\database.sqlite -ItemType File -Force
```

Затем выполните миграции:

```bash
php artisan migrate
```

### 6. Запустить сервер

```bash
php artisan serve
```

Приложение будет доступно по адресу: **http://localhost:8000**

## Настройка

Основные параметры в файле `.env`:

```env
APP_NAME="URL Shortener"
APP_URL=http://localhost:8000
APP_TIMEZONE=Europe/Moscow

DB_CONNECTION=sqlite
```

### MySQL (опционально)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=
```

После изменения выполните:

```bash
php artisan migrate
```

## Использование

### Маршруты

| URL | Описание |
|-----|----------|
| `/` | Главная — сокращение ссылок (только для авторизованных) |
| `/admin` | Личный кабинет (Filament) |
| `/admin/register` | Регистрация |
| `/admin/login` | Вход |
| `/{code}` | Редирект по короткой ссылке (6 символов) |

### Сценарий работы

1. Зарегистрируйтесь: `/admin/register`
2. После входа вы попадёте на главную `/` с формой сокращения
3. Вставьте URL (например, `https://example.com/page`) и нажмите «Сократить»
4. Скопируйте короткую ссылку вида `http://localhost:8000/abc123`
5. В кабинете `/admin` → «Мои ссылки»:
   - просмотр всех ссылок
   - создание и удаление
   - статистика переходов по каждой ссылке
6. На дашборде клик по блоку **«Мои ссылки»** открывает список ссылок
7. Клик по логотипу **ShortLink** в шапке кабинета или пункту **«Сократить ссылку»** в меню ведёт на главную

### База данных

Данные хранятся в файле:

```
database/yourName.sqlite
```

Просмотр через HeidiSQL (Laragon): **File → New session → SQLite** → указать путь к файлу.

## Структура проекта

```
app/
├── Filament/
│   ├── Pages/Auth/                     # Кастомные страницы входа и регистрации
│   ├── Resources/LinkResource.php      # CRUD ссылок в кабинете
│   └── Widgets/LinksOverview.php       # Виджет статистики на дашборде
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php          # Главная, создание ссылки
│   │   ├── RedirectController.php      # Редирект и трекинг кликов
│   │   └── NotFoundController.php      # Страница 404
│   ├── Requests/StoreLinkRequest.php   # Валидация URL
│   └── Responses/Auth/                 # Редирект после входа на главную
├── Models/
│   ├── User.php
│   ├── Link.php
│   └── Click.php
└── Services/ShortCodeGenerator.php     # Генерация уникального кода

database/migrations/                    # Миграции БД
public/
├── favicon.svg                         # Иконка сайта (вкладка браузера)
└── css/shortlink-brand.css             # Стили логотипа и брендинга
resources/views/
├── components/                         # Логотип, favicon, подзаголовки форм
├── filament/                           # Кастомные шаблоны кабинета
├── home.blade.php                      # Главная страница
├── layouts/public.blade.php            # Общий layout
└── errors/                             # Страницы ошибок (404, 429)
routes/web.php                          # Маршруты приложения
```

## Безопасность и ограничения

- Создание ссылок доступно **только авторизованным** пользователям
- Каждый пользователь видит **только свои** ссылки
- **Rate limit:**
  - создание ссылок — 10 запросов в минуту на пользователя
  - переходы по ссылкам — 60 запросов в минуту с одного IP
- Валидация URL с понятными сообщениями на русском языке.




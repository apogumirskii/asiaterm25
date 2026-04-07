# Asiaterm25 — WordPress Theme

## Проект
B2B сайт-каталог компании **Asiaterm.kg** — поставщик отопительного и охлаждающего оборудования из Европы (Кыргызстан, Бишкек).

## Стек технологий
- **WordPress** — CMS
- **Bootstrap 5.3.3** — CSS-фреймворк (CDN)
- **Owl Carousel 2.3.4** — слайдеры/карусели (CDN)
- **Lightbox2 2.11.3** — галерея изображений (CDN)
- **Font Awesome 6.5.2** — иконки (CDN)
- **Meta Box (RWMB)** — плагин кастомных полей (полная версия)
- **jQuery** — из ядра WordPress

## Структура файлов

```
asiaterm25/
├── style.css                    # Основные стили + CSS-переменные
├── functions.php                # Ядро: CPT, taxonomies, meta boxes, enqueue, SEO, AJAX
├── header.php                   # <head>, meta, OG, Schema.org
├── footer.php                   # wp_footer()
├── index.php                    # Fallback
├── single.php                   # Одиночная запись (пост)
├── page.php                     # Обычная страница
├── archive.php                  # Архив новостей
├── 404.php                      # Страница ошибки
│
├── page-front.php               # Главная (Template: TopPage)
├── page-singleproduct.php       # Товар (Template: Single product)
├── page-complexproduct.php      # Товар с моделями (Template: Complex product)
├── page-category.php            # Категория товаров (Template: Category)
├── page-catalog.php             # Каталог (Template: Catalog)
├── page-portfolio.php           # Портфолио (Template: Portfolio)
├── page-about.php               # О нас (Template: О нас)
├── page-services.php            # Услуги (Template: Услуги)
├── page-certificates.php        # Сертификаты (Template: Сертификаты)
├── page-partners.php            # Партнёрам (Template: Партнёрам) + форма запроса
├── page-contact.php             # Контакты (Template: Контакты)
├── taxonomy-prod_category.php   # Архив таксономии prod_category
│
├── template-parts/
│   ├── menu.php                 # Хедер: лого, поиск, навигация, мобильное меню
│   ├── phead.php                # Breadcrumb wrapper
│   ├── product-gallery.php      # Карусель галереи товара (Owl Carousel)
│   └── product-header.php       # Заголовок товара + описание + вариации + WhatsApp
│
├── blocks/
│   ├── product.php              # Карточка товара (переиспользуемая)
│   ├── category.php             # Карточка категории
│   └── single.php               # Карточка новости
│
├── page-top/                    # Секции главной страницы
│   ├── slider.php               # Hero-слайдер + promo-box
│   ├── about.php                # О компании (секция)
│   ├── cattop.php               # Категории
│   ├── popular.php              # Популярные товары (карусель)
│   ├── portfolio.php            # Портфолио (карусель + модалки)
│   ├── services.php             # Направления
│   ├── utp.php                  # Преимущества
│   ├── sertificat.php           # Сертификаты + видео
│   ├── news.php                 # Новости
│   ├── partners.php             # Партнёры (карусель логотипов)
│   └── ctasec.php               # Footer (контакты, соцсети, форма)
│
├── js/
│   ├── theme-front.js           # Инициализация каруселей главной + partners + video modal
│   ├── product-gallery.js       # Инициализация карусели товара
│   └── prod-category-thumbnail.js  # Админ: загрузка миниатюры категории
│
├── files/                       # Статические ассеты (демо-изображения, логотип)
│   └── logotest.svg             # Логотип компании
│
└── CLAUDE.md                    # Этот файл
```

## Custom Post Types

### `sliderims` — Слайдер
- Supports: title, thumbnail, page-attributes
- Meta fields: `sliderhead`, `slidertext`, `sliderlink`, `sliderbtntext`, `sliderfile`
- Используется в `page-top/slider.php`

## Таксономии

### `prod_category` — Категории продуктов
- Привязан к: `page`
- Hierarchical: да
- Slug: `prod-category`
- Имеет миниатюру (term meta: `prod_category_thumbnail`)

## Meta Box поля (RWMB)

### Все страницы (`product_params_base`)
- `prod_icon` (textarea) — SVG/HTML иконка
- `prod_service_gallery` (image_advanced) — Галерея до 20 фото

### Товарные шаблоны (`product_params`, template: page-singleproduct.php, page-complexproduct.php)
- `prod_show_on_home` (checkbox) — Показать в "Популярных"
- `prod_price` (text) — Цена
- `prod_service_gallery2` (image_advanced) — Доп. галерея
- `prod_var_titles` (text, clone) — Вариации
- `prod_specs` (wysiwyg) — Технические характеристики
- `prod_shortdesc` (wysiwyg) — Краткое описание
- `prod_costomdescr_title` (text) — Заголовок доп. блока
- `prod_costomdescr` (wysiwyg) — Доп. описание
- `prod_complect` (wysiwyg) — Комплектация
- `prod_downloads` (file_advanced) — Файлы для скачивания
- `prod_related_pages` (post) — Смежные товары
- `prod_portfolio_pages` (post) — Портфолио проекты

### О нас (`about_params`, template: page-about.php)
- `about_image` (image_advanced) — Фото
- `about_text` (wysiwyg) — Текст
- `about_features` (group, clone) — Преимущества (num, title, desc)

### Услуги (`services_params`, template: page-services.php)
- `services_list` (group, clone) — Услуги (icon, title, desc, link, image)

### Сертификаты (`cert_params`, template: page-certificates.php)
- `cert_video_url` (url) — YouTube видео
- `cert_heading` (text) — Заголовок
- `cert_buttons` (group, clone) — Кнопки (text, url)
- `cert_gallery` (image_advanced) — Галерея сертификатов

### Партнёрам (`partners_params`, template: page-partners.php)
- `partners_intro` (wysiwyg) — Вступление
- `partners_benefits` (group, clone) — Преимущества (icon, title, desc)
- `partners_logos` (image_advanced) — Логотипы партнёров

### Контакты (`contact_params`, template: page-contact.php)
- `contact_address` (text)
- `contact_phone` (text)
- `contact_email` (text)
- `contact_work_hours` (text)
- `contact_map_embed` (textarea) — iframe карты
- `contact_extra_info` (wysiwyg)

## Важные page ID
- **13** — Каталог (корень иерархии товаров)
- **29** — Портфолио (корень портфолио)

## Настройки сайта (Настройки → Общие → Контактная информация)
| Опция | Описание |
|-------|----------|
| `my_phone` | Основной телефон |
| `my_phone2` | Дополнительный телефон |
| `my_whatsapp` | WhatsApp номер (для wa.me ссылок) |
| `my_telegram` | Telegram ссылка |
| `my_instagramm` | Instagram ссылка |
| `my_mymail` | Email (для формы партнёра и контактов) |
| `my_facebook` | Facebook ссылка |
| `my_youtube` | YouTube ссылка |
| `my_adress` | Адрес |

## Кастомные размеры изображений
| Название | Размер | Где использовать |
|----------|--------|-----------------|
| `small` | 60x60 | Thumbnails карусели |
| `vert-thumb` | 400x800 | Вертикальные изображения |
| `catalog-thumb` | 300x400 | Карточки товаров, категорий |
| `slider-desc` | 1920x350 | Desktop-слайдер |
| `slider-mob` | 720x720 | Mobile-слайдер |
| `costom-gallery` | 1290x580 | Галерея, портфолио |

## Правила разработки
- **Логотип** задаётся в шаблоне (`files/logotest.svg`), НЕ через настройки
- **Lazy loading** — `loading="lazy"` на всех `<img>` кроме hero-слайдера и логотипа
- **Кастомные размеры** — всегда используй подходящий размер вместо `full`/`large`
- **CSS-переменные** определены в начале `style.css` (цвета, шрифты, тени, радиусы)
- **Owl Carousel и Lightbox** загружаются условно — только на шаблонах, где используются
- **Inline JS** запрещён — все скрипты в `js/` и энкьюируются через `functions.php`
- **Polylang не используется** — все строки через `__()` / `esc_html_e()` с textdomain `asiaterm25`
- **WhatsApp ссылки** — используй `get_option('my_whatsapp')` с fallback на `my_phone`

## SEO
- `title-tag` support через WordPress API
- Meta description: `asiaterm_meta_description()` в `functions.php`
- Open Graph теги в `header.php`
- Schema.org JSON-LD: Organization, Product, BreadcrumbList, WebPage
- Breadcrumbs с microdata (`the_breadcrumb()`)

## AJAX
- `partner_form_send` — отправка формы партнёра на email через `wp_mail()`

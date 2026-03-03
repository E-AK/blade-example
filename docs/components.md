# Документация по компонентам

Компоненты приложения: Blade-компоненты (классы в `App\View\Components` и анонимные в `resources/views/components/`) и JS-модули UI в `resources/js/ui/`.

---

## 1. Кнопка — `<x-button>`

**Класс:** `App\View\Components\Button`

| Атрибут | Тип | По умолчанию | Описание |
|--------|-----|--------------|----------|
| `type` | string | `'main'` | Вариант: `main`, `secondary`, `stroke`, `danger`, `string`, `danger-string` |
| `size` | string | `'medium'` | Размер: `large`, `medium`, `small` |
| `disabled` | bool | `false` | Неактивная кнопка |
| `icon-position` | string | `'none'` | Иконка: `none`, `left`, `right`, `only` |
| `stretch` | bool | `false` | Растянуть по ширине |
| `rounded` | string | `'full'` | Скругление: `full`, `square` |
| `href` | ?string | `null` | Если задан — рендерится как `<a>` |
| `extra-attributes` | array | `[]` | Доп. HTML-атрибуты |

**Слоты:** `default` (текст), `icon` (иконка при `icon-position` ≠ `none`).

```blade
<x-button type="main" size="medium">Сохранить</x-button>
<x-button type="stroke" icon-position="left" :href="$url">
    <x-slot:icon><x-icon name="arrow_right" :size="20" /></x-slot:icon>
    Перейти
</x-button>
```

---

## 2. Оповещения и тосты

### 2.1 Alert — `<x-alert>`

**Класс:** `App\View\Components\Alert`

| Атрибут | Тип | По умолчанию | Описание |
|--------|-----|--------------|----------|
| `state` | string | `'success'` | `success`, `error`, `attention`, `info` |
| `title` | ?string | `null` | Заголовок (опционально) |
| `class` | string | `''` | Доп. CSS-классы |

**Слоты:** `default` (текст), `button` (кнопка действия).

```blade
<x-alert state="error" title="Ошибка">{{ $message }}</x-alert>
<x-alert state="success">
    Изменения сохранены.
    <x-slot:button><x-button size="small">Отмена</x-button></x-slot:button>
</x-alert>
```

### 2.2 Toast — `<x-toast>`

**Класс:** `App\View\Components\Toast`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `state` | string | `'info'` |
| `title` | ?string | `null` |
| `class` | string | `''` |

**Слот:** `default` — содержимое тоста.

---

## 3. Модальное окно и боковая панель

### 3.1 Modal — `<x-modal>`

**Класс:** `App\View\Components\Modal`

| Атрибут | Тип | По умолчанию | Описание |
|--------|-----|--------------|----------|
| `open` | bool | `false` | Показать/скрыть |
| `size` | string | `'small'` | `small`, `large` |
| `title` | ?string | `null` | Заголовок |
| `title-id` | ?string | `null` | ID для aria-labelledby |
| `width` | ?string | `null` | CSS width |
| `min-height` | ?string | `null` | CSS min-height |
| `close-button-attributes` | array | `[]` | Атрибуты кнопки закрытия |
| `overlay-attributes` | array | `[]` | Атрибуты оверлея |

**Слоты:** `default` (тело), `footer`, `titleIcon`.

Закрытие: диспатч события `modal-close` (например через `x-on:modal-close="open = false"`).

```blade
<x-modal :open="$showModal" title="Подтверждение" size="small">
    <p>Вы уверены?</p>
    <x-slot:footer>
        <x-button @click="$dispatch('modal-close')">Отмена</x-button>
        <x-button type="main">Подтвердить</x-button>
    </x-slot:footer>
</x-modal>
```

### 3.2 RightSidebar — `<x-right-sidebar>`

**Класс:** `App\View\Components\RightSidebar`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `open` | bool | `false` |
| `title` | ?string | `null` |
| `title-id` | ?string | `null` |
| `close-button-attributes` | array | `[]` |
| `overlay-attributes` | array | `[]` |

**Слот:** `default` — содержимое панели.

---

## 4. Dropdown — `<x-dropdown>`

**Класс:** `App\View\Components\Dropdown`

Использует Alpine.js `dropdown()` из `resources/js/ui/dropdown.js`.

| Атрибут | Тип | По умолчанию | Описание |
|--------|-----|--------------|----------|
| `items` | array | `[]` | Массив пунктов (см. ниже) или пусто — тогда слот |
| `actions` | bool | `false` | Стиль «действия» |
| `panel-match-trigger` | bool | `false` | Ширина панели по триггеру |
| `teleport` | bool | `false` | Рендер панели в body (для overflow) |
| `class` | string | `''` | Доп. класс корня |

**Слоты:** `trigger` (кнопка/триггер), `default` (если `items` пуст — кастомный контент панели).

Формат элемента в `items`:

- `separator` (bool) — разделитель
- `label`, `sublabel` (string)
- `icon` (string): `none`, `left`, `right`, `both`, `label`, `controllers`
- `iconName` (string) — имя иконки для `left`/`both`
- `state` (string): `default`, `disabled`
- `checked` (bool) — для `icon === 'controllers'` (чекбокс)
- `url` (string|null) — ссылка; если нет — `<button>`
- `extraAttributes` (array) — доп. атрибуты элемента

```blade
<x-dropdown :items="[
    ['label' => 'Редактировать', 'iconName' => 'actions_edit', 'icon' => 'left'],
    ['separator' => true],
    ['label' => 'Удалить', 'state' => 'danger', 'url' => $deleteUrl],
]" panel-match-trigger>
    <x-slot:trigger>
        <x-button type="stroke" icon-position="right">Действия</x-button>
    </x-slot:trigger>
</x-dropdown>
```

---

## 5. Формы

### 5.1 Input — `<x-input>` (анонимный)

**Файл:** `resources/views/components/input.blade.php`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `type` | string | `'main'` |
| `label` | ?string | `null` |
| `placeholder` | string | `''` |
| `name` | ?string | `null` |
| `id` | ?string | `null` |
| `value` | mixed | `null` |
| `disabled` | bool | `false` |
| `error` | ?string | `null` |
| `left-icon` | ?string | `null` |
| `right-icon` | ?string | `null` |
| `input-type` | string | `'text'` |
| `class` | string | `''` |

**Слоты:** `iconLeft`, `iconRight`, `rightIcons` (несколько иконок справа).

### 5.2 Select — `<x-select>`

**Класс:** `App\View\Components\Select`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `text` | ?string | `null` |
| `value` | ?string | `null` |
| `label` | ?string | `null` |
| `placeholder` | string | `'Выбор папки'` (в blade) |
| `left-icon` | ?string | `null` |
| `right-icon` | string | `'arrow_chevron_down'` |
| `type` | string | `'main'` |
| `state` | ?string | `null` |
| `disabled` | bool | `false` |
| `error` | ?string | `null` |
| `cursor` | bool | `false` |
| `options` | array | `[]` |
| `description` | ?string | `null` |
| `class` | string | `''` |

В blade у select-wrapper есть также `pilled`.

### 5.3 Checkbox — `<x-checkbox>` (анонимный)

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `name` | ?string | `null` |
| `value` | string | `'1'` |
| `checked` | bool | `false` |
| `disabled` | bool | `false` |
| `error` | ?string | `null` |
| `size` | string | `'16'` — `16` или `20` |
| `label` | ?string | `null` |
| `class` | string | `''` |

Поддерживает `wire:model` для Livewire.

### 5.4 Radio — `<x-radio>` (анонимный)

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `name` | ?string | `null` |
| `value` | string | `''` |
| `checked` | bool | `false` |
| `disabled` | bool | `false` |
| `error` | ?string | `null` |
| `size` | string | `'16'` |
| `label` | ?string | `null` |
| `class` | string | `''` |

### 5.5 Switch — `<x-switch>` (анонимный)

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `name` | ?string | `null` |
| `checked` | bool | `false` |
| `disabled` | bool | `false` |
| `loading` | bool | `false` |
| `size` | string | `'large'` — `small` или `large` |
| `show-text` | bool | `false` |
| `class` | string | `''` |

### 5.6 Multiselect — `<x-multiselect>`

**Класс:** `App\View\Components\Multiselect`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `name` | ?string | `null` |
| `placeholder` | ?string | `'Сотрудники'` |
| `search-placeholder` | ?string | `'Поиск...'` |
| `left-icon` | ?string | `null` |
| `options` | array | `[]` — ключ = value, значение = label или `['label' => ..., 'tag' => [...]]` |
| `selected` | array | `[]` — массив выбранных value |
| `disabled` | bool | `false` |
| `error` | ?string | `null` |
| `state` | ?string | `null` |
| `show-right-icon` | bool | `false` |
| `tag-bg`, `tag-color`, `tag-border-color` | string | для тегов выбранных |
| `class` | string | `''` |
| `allow-custom` | bool | `false` |

Использует JS: `resources/js/ui/multiselect.js`.

### 5.7 Search — `<x-search>`

**Класс:** `App\View\Components\Search`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `size` | string | `'md'` |
| `placeholder` | string | `''` |
| `value` | string | `''` |
| `selected` | bool | `false` |
| `description` | string | `''` |
| `tags` | array | `[]` |
| `clearable` | bool | `true` |
| `class` | string | `''` |
| `pilled` | bool | `false` |

---

## 6. Статус, тег, подсказка

### 6.1 Status — `<x-status>`

**Класс:** `App\View\Components\Status`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `variant` | string | `'success'` — `success`, `error`, `attention`, `info`, `pause` |
| `has-right-icon` | bool | `false` |
| `text` | ?string | `null` (иначе текст по варианту) |

### 6.2 Tag — `<x-tag>`

**Класс:** `App\View\Components\Tag`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `text` | string | `''` |
| `size` | string | `'md'` — `sm`, `md`, `lg` |
| `icon` | string | `'none'` — `none`, `left`, `right`, `both` |
| `selected` | bool | `false` |
| `disabled` | bool | `false` |
| `hoverable` | bool | `true` |
| `bg`, `color`, `border-color` | string | Цвета (CSS-переменные) |
| `hover-bg`, `hover-color`, `hover-border-color` | string | При наведении |
| `border-style` | string | `'solid'` |
| `left-icon`, `right-icon` | string | Имена иконок |
| `right-icon-attributes` | array | `[]` |
| `class` | string | `''` |

**Слот:** по умолчанию можно передать контент вместо `text`.

### 6.3 Tooltip — `<x-tooltip>`

**Класс:** `App\View\Components\Tooltip`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `text` | string | `''` |
| `placement` | string | `'top'` |

**Слот:** `default` — элемент, к которому привязан тултип.

Используется вместе с JS: `resources/js/ui/tooltip.js`.

---

## 7. Layout и навигация

### 7.1 Topbar — `<x-topbar>`

**Класс:** `App\View\Components\Topbar`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `header-info-text` | ?string | `null` |
| `header-title-text` | string | `''` |

Хлебные крошки берутся из `Spatie\Navigation\Facades\Navigation`.

### 7.2 Sidebar — `<x-sidebar.sidebar>`

**Класс:** `App\View\Components\Sidebar\Sidebar`

Без атрибутов. Дерево меню из `Navigation::make()->tree()`.

### 7.3 MenuItem — `<x-sidebar.menu-item>`

**Класс:** `App\View\Components\Sidebar\MenuItem`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `text` | string | `''` |
| `short-text` | string | `''` |
| `icon` | ?string | `null` |
| `trailing-icon` | ?string | `null` |
| `active` | bool | `false` |
| `has-children` | bool | `false` |
| `href` | string | `'#'` |
| `class` | string | `''` |
| `as-button` | bool | `false` |
| `is-new` | bool | `false` |
| `is-action` | bool | `false` |
| `is-submenu` | bool | `false` |
| `is-account-item` | bool | `false` |
| `is-list-action` | bool | `false` |
| `badge-count` | ?string | `null` |

---

## 8. Таблица и карточки

### 8.1 Table — `<x-table>`

**Класс:** `App\View\Components\Table`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `data-table` | `Yajra\DataTables\Html\Builder` | обязательный |
| `search-placeholder` | string | `''` |
| `search-class` | string | `''` |
| `has-sidebar` | bool | `false` |
| `sidebar-label` | ?string | `null` |
| `show-search` | bool | `true` |
| `search-pilled` | bool | `false` |
| `search-width` | ?string | `null` |

### 8.2 UserCard — `<x-user-card>`

**Класс:** `App\View\Components\UserCard`

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `name` | string | обязательный |
| `email` | string | `''` |
| `role` | string | `'Менеджер'` |
| `tag-left-icon` | string | `'actions_profile'` |
| `href` | ?string | `null` |
| `wrapper-class` | string | `'user-card'` |

---

## 9. Степпер

### 9.1 Stepper — `<x-stepper>` (анонимный)

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `class` | string | `''` |

**Слот:** `default` — дочерние `<x-stepper-item>`.

### 9.2 Stepper-item — `<x-stepper-item>` (анонимный)

| Атрибут | Тип | По умолчанию |
|--------|-----|--------------|
| `step-number` | int | `1` |
| `step-label` | string | `'Шаг 1'` |
| `title` | string | `'Заголовок'` |
| `state` | string | `'default'` — `default`, `active`, `success`, `error` |
| `is-last` | bool | `false` |
| `class` | string | `''` |

---

## 10. Ячейки таблиц и прочие

- **actions-cell** — кнопки действий в таблице.
- **status-cell** — ячейка со статусом.
- **switch-cell** — переключатель в ячейке.
- **secret-cell** — скрытое значение (раскрытие по клику).
- **short-link-cell** — короткая ссылка.
- **drag-handle** — ручка перетаскивания.
- **button-toggle** / **button-toggle-item** — группа кнопок-переключателей.
- **layout/stack** — вертикальный стек.

Компоненты Sidebar Profile: `sidebar.profile.profile`, `sidebar.profile.profile-card`, `sidebar.profile.balance` — см. классы в `App\View\Components\Sidebar\Profile\*`.

---

## 11. JS UI-модули (`resources/js/ui/`)

Используются из Blade через Alpine.js или при инициализации приложения:

| Файл | Назначение |
|------|------------|
| `dropdown.js` | Alpine `dropdown()` — открытие/закрытие, позиция панели, teleport |
| `multiselect.js` | Логика мультиселекта (поиск, выбор, теги) |
| `toast.js` | Показ тостов (если тосты показываются через JS) |
| `tooltip.js` | Инициализация тултипов |
| `search.js` | Поведение поля поиска |
| `buttonToggle.js` | Группа переключаемых кнопок |
| `customScroll.js` | Кастомный скролл |
| `dataDispatch.js` | Вспомогательные события/данные |

Подключение: через `app.js` / Vite; в Blade компоненты подключают Alpine-директивы (`x-data="dropdown()"` и т.д.).

---

## Общие правила

- Иконки задаются именем и подставляются через `<x-icon :name="..." />`.
- Для форм поддерживаются `wire:model` (Livewire) там, где это указано в компоненте.
- Стили — по проекту (Bootstrap 5 + кастомные классы), без лишнего кастомного CSS.
- Модалки и дропдауны управляются через Alpine.js и события (`modal-close`, `dropdown-close-others` и т.д.).

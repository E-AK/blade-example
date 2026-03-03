@php
    $headerTitleText = 'Менеджер паролей';
    $trashBtnClass = '{ \'password-manager-sidebar__trash-btn--active\': $store.passwordManager.showTrashed }';
    $trashBtnAria = '$store.passwordManager.showTrashed';
    $trashBtnClick = '$store.passwordManager.showTrashed = !$store.passwordManager.showTrashed; window.dispatchEvent(new CustomEvent(\'password-manager-reload-table\'))';
    $folderDropdownItems = [
        [
            'label' => 'Создать подпапку',
            'iconName' => 'document_folder_add',
            'icon' => 'left',
            'state' => 'default',
            'extraAttributes' => [
                'x-on:click' => "(function(p){ if (p && p.dataset.folderId) { window.dispatchEvent(new CustomEvent(\"dropdown-close-others\", { detail: \"close-all\" })); \$dispatch(\"password-manager-start-new-subfolder\", { parentId: p.dataset.folderId, parentDepth: parseInt(p.dataset.folderDepth, 10) || 0 }); } if (p && p.dataset.dropdownId) window.dispatchEvent(new CustomEvent('dropdown-close-self', { detail: p.dataset.dropdownId })); })(\$el.closest('.dropdown-panel'))",
            ],
        ],
        [
            'label' => 'Переименовать',
            'iconName' => 'actions_settings',
            'icon' => 'left',
            'state' => 'default',
            'extraAttributes' => [
                'x-on:click' => "(function(p){ if (p && p.dataset.folderId) { \$dispatch(\"password-manager-start-rename\", { id: p.dataset.folderId, name: p.dataset.folderName }); } if (p && p.dataset.dropdownId) window.dispatchEvent(new CustomEvent('dropdown-close-self', { detail: p.dataset.dropdownId })); })(\$el.closest('.dropdown-panel'))",
            ],
        ],
        [
            'label' => 'Удалить',
            'iconName' => 'actions_trash',
            'icon' => 'left',
            'state' => 'danger',
            'extraAttributes' => [
                'x-on:click' => "(function(p){ if (p && p.dataset.folderId) { \$dispatch(\"password-manager-open-delete-modal\", { id: p.dataset.folderId, name: p.dataset.folderName, passwordsCount: parseInt(p.dataset.folderPasswordsCount, 10) || 0 }); } if (p && p.dataset.dropdownId) window.dispatchEvent(new CustomEvent('dropdown-close-self', { detail: p.dataset.dropdownId })); })(\$el.closest('.dropdown-panel'))",
            ],
        ],
    ];
            $tagDropdownItems = [
        ['label' => 'Переименовать', 'iconName' => 'actions_settings', 'icon' => 'left', 'state' => 'default'],
        ['label' => 'Удалить', 'iconName' => 'actions_trash', 'icon' => 'left', 'state' => 'danger'],
    ];
    $tagsSidebarThemeBtnClassExpr = "tagsSidebarTagsColored ? 'password-manager-sidebar__theme-btn--active' : ''";
    $tagsSidebarRowStyleExpr = "tagsSidebarTagsColored && tagColor ? ('background-color: ' + tagColor + '; color: ' + (tagColor === '#FFCB66' ? '#141414' : '#FFFFFF') + '; border-color: transparent') : ''";
    $tagsSidebarRowClassExpr = "tagsSidebarTagsColored && tagColor ? 'password-manager-tags-sidebar__tag-row--colored' : ''";
    $folderSelectOptions = collect($folders)->mapWithKeys(fn ($f) => [$f['name'] => $f['name']])->all();
    $tagSelectOptions = collect($tags)->mapWithKeys(fn ($t) => [(is_array($t) ? ($t['name'] ?? '') : $t) => (is_array($t) ? ($t['name'] ?? '') : $t)])->filter()->all();
@endphp

@extends('layouts.app-two-column')

@section('topbar_buttons')
    <x-button type="string" size="large" icon-position="left">
        <x-slot:icon>
            <x-icon name="document_book" :size="20" />
        </x-slot:icon>
        Информация
    </x-button>
    <x-button
        type="main"
        size="large"
        icon-position="left"
        :extra-attributes="['onclick' => 'Alpine.store(\'passwordManager\').openAddSidebar()']"
    >
        <x-slot:icon>
            <x-icon name="validation_add_circle" :size="20" />
        </x-slot:icon>
        Создать новый пароль
    </x-button>
    <x-button
        type="stroke"
        size="large"
        icon-position="left"
        :extra-attributes="['onclick' => 'Alpine.store(\'passwordManager\').openAccessSidebar()']"
    >
        <x-slot:icon>
            <x-icon name="actions_share" :size="20" />
        </x-slot:icon>
        Управление доступами
    </x-button>
@endsection

@section('content_sidebar')
    <aside class="password-manager-sidebar d-flex flex-column h-100" x-data="{ get hasFolderScroll() { return $store.passwordManager?.folderListHasScroll === true } }">
        <div
            class="password-manager-sidebar__section password-manager-sidebar__section--folders d-flex flex-column min-h-0"
            x-data="{ showNewFolderInput: false }"
            x-effect="showNewFolderInput && \$nextTick(() => setTimeout(() => { const el = \$refs.newFolderInput && \$refs.newFolderInput.querySelector(&#39;input&#39;); if (el) el.focus(); }, 0))"
        >
            <div class="password-manager-sidebar__header password-manager-sidebar__header--sticky d-flex align-items-center justify-content-between">
                <span class="password-manager-sidebar__title">Папки</span>
                <x-button
                    type="stroke"
                    size="small"
                    icon-position="only"
                    class="password-manager-sidebar__add-btn rounded-circle p-2"
                    :extra-attributes="['x-on:click' => 'showNewFolderInput = !showNewFolderInput']"
                >
                    <x-slot:icon>
                        <x-icon name="actions_plus" :size="16" />
                    </x-slot:icon>
                </x-button>
            </div>
            <div
                class="d-flex password-manager-sidebar__folders-wrap flex-grow-1"
                x-data="passwordManagerFolders()"
                @password-manager-open-delete-modal.window="folderToDelete = $event.detail; deleteTarget = 'delete_with'; deleteModalSelectOpen = false; deleteModalOpen = true"
                @password-manager-start-rename.window="startRename($event.detail)"
                @password-manager-start-new-subfolder.window="startNewSubfolder($event.detail)"
                @password-manager-clear-folder.window="selectedId = null"
            >
                <script type="application/json" id="password-manager-folders-data">@json($folders)</script>
                <div
                    class="password-manager-sidebar__folders-scroll"
                    x-ref="foldersScroll"
                    data-custom-scroll
                >
                    <div class="password-manager-sidebar__folders-list d-flex flex-column">
                        <div
                            class="password-manager-sidebar__new-folder"
                            x-show="showNewFolderInput"
                            x-cloak
                            x-ref="newFolderInput"
                        >
                            <div class="password-manager-sidebar__new-folder-inner">
                                <x-input
                                    type="stroke"
                                    name="new_folder_name"
                                    placeholder="Название папки"
                                    leftIcon="document_folder"
                                    class="password-manager-sidebar__new-folder-input"
                                />
                            </div>
                        </div>
                        <ul
                            x-ref="folderList"
                            id="password-manager-folders"
                            class="password-manager-folders list-unstyled mb-0"
                            role="list"
                        >
                    <li
                        class="password-manager-sidebar__folder-spacer password-manager-folder-item--no-drag"
                        aria-hidden="true"
                        x-show="topSpacerHeight > 0"
                        x-cloak
                        :style="{ height: topSpacerHeight + 'px' }"
                    ></li>
                    <template x-for="item in renderedFolders" :key="item.id">
                        <div style="display: contents">
                        <li
                            class="password-manager-folder-item"
                            :class="{
                                'password-manager-folder-item--selected': selectedId === item.id && editingFolderId !== item.id,
                                'password-manager-folder-item--depth-1': item.depth === 1 && editingFolderId !== item.id,
                                'password-manager-folder-item--parent': item.hasChildren && editingFolderId !== item.id,
                                'password-manager-folder-item--editing': editingFolderId === item.id
                            }"
                            :data-folder="item.name"
                            :data-id="item.id"
                            :data-depth="item.depth"
                            :style="{ marginLeft: (item.depth * 20) + 'px' }"
                            @click="editingFolderId !== item.id && !$event.target.closest('.password-manager-folder-item__handle') && !$event.target.closest('.password-manager-folder-item__arrow') && !$event.target.closest('.password-manager-folder-item__icon-chevron') && !$event.target.closest('.password-manager-folder-item__menu') && select(item.id)"
                        >
                            <template x-if="editingFolderId === item.id">
                                <div class="password-manager-sidebar__new-folder">
                                    <div class="password-manager-sidebar__new-folder-inner">
                                        <div class="input-wrapper input-wrapper--stroke flex-grow-1 min-w-0 password-manager-sidebar__new-folder-input">
                                            <div class="input-body input-body--stroke state-filled">
                                                <span class="input-icon input-icon--left" aria-hidden="true">
                                                    <x-icon name="document_folder" :size="20" />
                                                </span>
                                                <div class="input-content">
                                                    <input
                                                        type="text"
                                                        class="input-field"
                                                        placeholder="Название папки"
                                                        x-model="editingFolderName"
                                                        data-rename-input
                                                        @keydown.enter.prevent="saveRename()"
                                                        @keydown.escape.prevent="cancelRename()"
                                                        @blur="saveRename()"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="editingFolderId !== item.id">
                                <div class="password-manager-folder-item__content d-flex align-items-center flex-grow-1 min-w-0 gap-2">
                                    <x-drag-handle class="password-manager-folder-item__handle" />
                                    <span class="password-manager-folder-item__icon">
                                        <template x-if="item.hasChildren">
                                            <span class="password-manager-folder-item__icon-inner password-manager-folder-item__icon-inner--parent">
                                                <span class="password-manager-folder-item__icon-folder">
                                                    <x-icon name="document_folder_list" :size="20" />
                                                </span>
                                                <button
                                                    type="button"
                                                    class="password-manager-folder-item__icon-chevron"
                                                    :aria-expanded="!!expandedIds[item.id]"
                                                    @click.stop="toggleExpand(item.id)"
                                                >
                                                    <span x-show="!expandedIds[item.id]"><x-icon name="arrow_down" :size="20" /></span>
                                                    <span x-show="!!expandedIds[item.id]"><x-icon name="arrow_up" :size="20" /></span>
                                                </button>
                                            </span>
                                        </template>
                                        <template x-if="!item.hasChildren">
                                            <span class="password-manager-folder-item__icon-inner d-inline-flex">
                                                <x-icon name="document_folder" :size="20" />
                                            </span>
                                        </template>
                                    </span>
                                    <span class="password-manager-folder-item__label text-truncate" x-text="item.name"></span>
                                    <div
                                        class="password-manager-folder-item__menu"
                                        x-bind:data-folder-id="item.id"
                                        x-bind:data-folder-name="item.name"
                                        x-bind:data-folder-depth="item.depth"
                                        x-bind:data-folder-passwords-count="item.passwordsCount ?? 0"
                                    >
                                        <x-dropdown :items="$folderDropdownItems" :actions="true" :teleport="true" class="dropdown-trigger-wrapper dropdown-root--align-right">
                                            <x-slot:trigger>
                                                <button
                                                    type="button"
                                                    class="password-manager-folder-item__menu-trigger"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                >
                                                    <x-icon name="arrow_three_dot_vertical" :size="20" />
                                                </button>
                                            </x-slot:trigger>
                                        </x-dropdown>
                                    </div>
                                </div>
                            </template>
                        </li>
                        <li
                            class="password-manager-folder-item password-manager-folder-item--editing password-manager-folder-item--no-drag"
                            x-show="newSubfolderParentId === item.id"
                            x-cloak
                            :style="{ marginLeft: ((item.depth + 1) * 20) + 'px' }"
                            @mousedown.stop
                        >
                            <div
                                class="password-manager-sidebar__new-folder"
                                x-effect="newSubfolderParentId === item.id && $nextTick(() => { setTimeout(() => { const i = $el.querySelector('input'); if (i) i.focus(); }, 0); })"
                            >
                                <div class="password-manager-sidebar__new-folder-inner">
                                    <div class="input-wrapper input-wrapper--stroke flex-grow-1 min-w-0 password-manager-sidebar__new-folder-input">
                                        <div class="input-body input-body--stroke state-filled">
                                            <span class="input-icon input-icon--left" aria-hidden="true">
                                                <x-icon name="document_folder" :size="20" />
                                            </span>
                                            <div class="input-content">
                                                <input
                                                    type="text"
                                                    class="input-field"
                                                    placeholder="Название папки"
                                                    x-model="newSubfolderName"
                                                    data-new-subfolder-input
                                                    @keydown.enter.prevent="saveNewSubfolder()"
                                                    @keydown.escape.prevent="cancelNewSubfolder()"
                                                    @blur="saveNewSubfolder()"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        </div>
                    </template>
                    <li
                        class="password-manager-sidebar__folder-spacer password-manager-folder-item--no-drag"
                        aria-hidden="true"
                        x-show="bottomSpacerHeight > 0"
                        x-cloak
                        :style="{ height: bottomSpacerHeight + 'px' }"
                    ></li>
                </ul>
                    </div>
                </div>

                <template x-if="deleteModalOpen">
                    <x-modal
                        :open="true"
                        title="Удалить папку?"
                        size="small"
                        width="560px"
                        :close-button-attributes="['x-on:click' => 'closeDeleteModal()']"
                        :overlay-attributes="['x-on:click.self' => 'closeDeleteModal()']"
                    >
                        <div class="password-manager-delete-modal__body d-flex flex-column align-items-start gap-3">
                            <p class="password-manager-delete-modal__text mb-0" x-show="folderToDelete" x-text="deleteModalMessage"></p>
                            <p class="password-manager-delete-modal__text mb-0">Их можно удалить вместе с папкой или переместить в другую:</p>
                            <div class="password-manager-delete-modal__select-wrap w-100 position-relative" x-on:click.outside="deleteModalSelectOpen = false">
                                <button
                                    type="button"
                                    class="password-manager-delete-modal__select d-flex flex-row align-items-center justify-content-between gap-2 w-100"
                                    :class="{ 'password-manager-delete-modal__select--open': deleteModalSelectOpen }"
                                    @click.stop="deleteModalSelectOpen = !deleteModalSelectOpen"
                                    aria-haspopup="listbox"
                                    :aria-expanded="deleteModalSelectOpen"
                                >
                                    <span class="d-flex align-items-center gap-2 flex-grow-1 min-w-0">
                                        <x-icon name="document_folder" :size="20" />
                                        <span class="password-manager-delete-modal__select-text text-truncate" x-text="deleteModalSelectedLabel"></span>
                                    </span>
                                    <x-icon name="arrow_chevron_down" :size="20" />
                                </button>
                                <div
                                    x-show="deleteModalSelectOpen"
                                    class="dropdown-panel password-manager-delete-modal__select-panel"
                                    role="listbox"
                                    x-cloak
                                >
                                    <div class="dropdown-panel__inner">
                                        <template x-for="opt in deleteModalOptions" :key="opt.value">
                                            <button
                                                type="button"
                                                class="dropdown-item dropdown-item--left dropdown-item--default w-100 text-start"
                                                role="option"
                                                :aria-selected="deleteTarget === opt.value"
                                                @click="deleteTarget = opt.value; deleteModalSelectOpen = false"
                                            >
                                                <span class="dropdown-item__icon dropdown-item__icon--left">
                                                    <x-icon name="document_folder" :size="20" />
                                                </span>
                                                <span class="dropdown-item__label" x-text="opt.label"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-slot:footer>
                            <div class="d-flex gap-2 justify-content-end w-100">
                                <x-button
                                    type="stroke"
                                    size="large"
                                    :extra-attributes="['x-on:click' => 'closeDeleteModal()']"
                                >
                                    Отмена
                                </x-button>
                                <x-button
                                    type="danger"
                                    size="large"
                                    :extra-attributes="['x-on:click' => 'closeDeleteModal()']"
                                >
                                    Удалить
                                </x-button>
                            </div>
                        </x-slot:footer>
                    </x-modal>
                </template>
            </div>
        </div>

        @php
            $tagColorOptions = [
                    ['value' => '#A4A4A4', 'label' => 'А', 'textColor' => '#FFFFFF'],
                    ['value' => '#FFCB66', 'label' => 'А', 'textColor' => '#141414'],
                    ['value' => '#33B868', 'label' => 'А', 'textColor' => '#FFFFFF'],
                    ['value' => '#EB4B4B', 'label' => 'А', 'textColor' => '#FFFFFF'],
                    ['value' => '#3090F0', 'label' => 'А', 'textColor' => '#FFFFFF'],
                    ['value' => '#A355F8', 'label' => 'А', 'textColor' => '#FFFFFF'],
                ['value' => '#EE59D8', 'label' => 'А', 'textColor' => '#FFFFFF'],
            ];
            // Выражения Alpine — в PHP-строках, чтобы Blade не компилировал их как PHP
            $themeBtnClassExpr = "tagsColored ? 'password-manager-sidebar__theme-btn--active' : ''";
            $tagWrapClassExpr = "(tagsColored && tagColor) ? 'password-manager-sidebar__tag-wrap--colored' : ''";
            $tagWrapStyleExpr = "tagsColored && tagColor ? ('--tag-wrap-bg: ' + tagColor + '; --tag-wrap-color: ' + tagTextColor(tagColor) + '; --tag-wrap-border: ' + tagColor) : ''";
        @endphp
        <div
            class="d-flex flex-column password-manager-sidebar__section password-manager-sidebar__section--tags"
            x-data='{
                showNewTagInput: false,
                newTagName: "",
                showColorPicker: false,
                selectedTagColor: "#A4A4A4",
                tagsColored: false,
                tagColorOptions: @json($tagColorOptions),
                pickColor(color) {
                    this.selectedTagColor = color.value;
                    this.showColorPicker = false;
                },
                textColorForBg(bg) {
                    return bg === "#FFCB66" ? "#141414" : "#FFFFFF";
                },
                tagTextColor(hex) {
                    return hex === "#FFCB66" ? "#141414" : "#FFFFFF";
                }
            }'
        >
            <div class="password-manager-sidebar__header d-flex align-items-center justify-content-between">
                <span class="password-manager-sidebar__title">Теги</span>
                <div class="d-flex gap-2">
                    <x-button
                        type="stroke"
                        size="small"
                        icon-position="only"
                        class="password-manager-sidebar__add-btn password-manager-sidebar__theme-btn rounded-circle p-2"
                        :extra-attributes="[':class' => $themeBtnClassExpr, 'x-on:click' => 'tagsColored = !tagsColored']"
                    >
                        <x-slot:icon>
                            <x-icon name="actions_theme" :size="16" />
                        </x-slot:icon>
                    </x-button>
                    <x-button
                            type="stroke"
                            size="small"
                            icon-position="only"
                            class="password-manager-sidebar__add-btn rounded-circle p-2"
                            :extra-attributes="['x-on:click' => 'showNewTagInput = !showNewTagInput; if (showNewTagInput) { $nextTick(() => { $refs.newTagInput?.focus() }) }']"
                    >
                        <x-slot:icon>
                            <x-icon name="actions_plus" :size="16" />
                        </x-slot:icon>
                    </x-button>
                </div>
            </div>
            <div class="password-manager-sidebar__tags d-flex flex-wrap gap-2 align-items-center">
                <div
                    class="password-manager-sidebar__new-tag"
                    x-show="showNewTagInput"
                    x-cloak
                    x-ref="newTagWrap"
                    @click.outside="showNewTagInput = false; newTagName = ''; showColorPicker = false"
                >
                    <div class="password-manager-sidebar__new-tag-inner">
                        <span class="password-manager-sidebar__new-tag-icon" aria-hidden="true">
                            <x-icon name="specific_tag" :size="20" />
                        </span>
                        <input
                            type="text"
                            class="password-manager-sidebar__new-tag-input"
                            placeholder="Название тега"
                            maxlength="100"
                            x-ref="newTagInput"
                            x-model="newTagName"
                            @keydown.enter.prevent="if (newTagName.trim()) { showNewTagInput = false; newTagName = '' }"
                            @keydown.escape.prevent="showColorPicker ? (showColorPicker = false) : (showNewTagInput = false, newTagName = '')"
                        />
                        <div class="password-manager-sidebar__new-tag-add-wrap position-relative">
                            <button
                                type="button"
                                class="password-manager-sidebar__new-tag-add"
                                title="Выбор цвета"
                                :style="{ backgroundColor: selectedTagColor, color: textColorForBg(selectedTagColor) }"
                                @click.stop="showColorPicker = !showColorPicker"
                            >
                                <span aria-hidden="true">А</span>
                            </button>
                            <div
                                class="password-manager-sidebar__tag-color-picker"
                                x-show="showColorPicker"
                                x-cloak
                                @click.outside="showColorPicker = false"
                            >
                                <template x-for="opt in tagColorOptions" :key="opt.value">
                                    <button
                                        type="button"
                                        class="password-manager-sidebar__tag-color-option"
                                        :style="{ backgroundColor: opt.value, color: opt.textColor }"
                                        :title="opt.value"
                                        @click="pickColor(opt)"
                                    >
                                        <span x-text="opt.label"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($tags as $tag)
                    @php
                        $tagName = is_array($tag) ? ($tag['name'] ?? '') : $tag;
                        $tagColor = is_array($tag) ? ($tag['color'] ?? null) : null;
                    @endphp
                    <span
                        class="password-manager-sidebar__tag-wrap password-manager-sidebar__tag-wrap--clickable"
                        role="button"
                        tabindex="0"
                        data-tag-name="{{ e($tagName) }}"
                        {!! ' :class="' . e($tagWrapClassExpr) . '"' !!}
                        x-data='{ tagColor: @json($tagColor) }'
                        {!! ' :style="' . e($tagWrapStyleExpr) . '"' !!}
                        @click="$store.passwordManager.selectedTag = $el.dataset.tagName || ''; window.dispatchEvent(new CustomEvent('password-manager-reload-table'))"
                    >
                        <x-tag :text="$tagName" size="md" :hoverable="false" />
                    </span>
                @endforeach
            </div>
            <x-button
                type="string"
                size="small"
                class="justify-content-start"
                :extra-attributes="['x-on:click' => 'window.dispatchEvent(new CustomEvent(\'password-manager-open-tags-sidebar\'))']"
            >
                Управление тегами
            </x-button>
        </div>

        <div class="password-manager-sidebar__section password-manager-sidebar__section--trash mt-auto"
             x-data
             @@password-manager-reload-table.window="const wrapper = document.getElementById('password-manager-table'); if (wrapper) { const store = Alpine.store('passwordManager'); wrapper.setAttribute('data-deleted-only', store && store.showTrashed ? '1' : '0'); } const table = document.getElementById('password-manager-table')?.querySelector('table'); if (table && window.$ && $(table).DataTable) $(table).DataTable().ajax.reload();">
            <button
                type="button"
                role="button"
                class="btn btn--string btn--medium password-manager-sidebar__trash-btn w-100 justify-content-start"
                :class="{!! $trashBtnClass !!}"
                :aria-pressed="{!! $trashBtnAria !!}"
                @@click="{!! $trashBtnClick !!}"
            >
                <span class="btn__inner">
                    <span class="btn__icon btn__icon--left password-manager-sidebar__trash-btn-icon" aria-hidden="true">
                        <x-icon name="actions_trash" :size="20" />
                    </span>
                    <span class="btn__label">Удаленные пароли</span>
                </span>
            </button>
        </div>
    </aside>
@endsection

@section('content_main')
    @php
        $pmAddSidebarOpen = '$store.passwordManager.addSidebarOpen';
        $pmCloseSidebar = '$store.passwordManager.addSidebarOpen = false';
        $pmEditEntryId = '$store.passwordManager.editEntryId';
        $pmEditEntry = '$store.passwordManager.editEntry';
        $pmEditEntryWarning = '$store.passwordManager.editEntry && $store.passwordManager.editEntry.warning';
        $pmEditEntryAlert = '$store.passwordManager.editEntry && $store.passwordManager.editEntry.alert';
        $pmEditEntryAlertBlock = '$store.passwordManager.editEntry && ($store.passwordManager.editEntry.warning || $store.passwordManager.editEntry.alert)';
        $pmEditEntryWarningText = '$store.passwordManager.editEntry ? ($store.passwordManager.editEntry.warning || \'\') : \'\'';
        $pmEditEntryAlertText = '$store.passwordManager.editEntry ? ($store.passwordManager.editEntry.alert || \'\') : \'\'';
        $pmTitleText = '$store.passwordManager.editEntryId ? \'Редактирование пароля\' : \'Создание нового пароля\'';
        $pmFormName = '$store.passwordManager.formName';
        $pmFormUrl = '$store.passwordManager.formUrl';
        $pmFormLogin = '$store.passwordManager.formLogin';
        $pmFormPassword = '$store.passwordManager.formPassword';
        $pmAccessCloseSidebar = '$store.passwordManager.accessSidebarOpen = false';
        $accessTableOptions = $accessDataTable->getOptions();
    @endphp
    <div
        class="password-manager-page d-flex flex-column flex-grow-1 min-h-0"
        x-data="{ tagsSidebarOpen: false, tagsSidebarTagsColored: false }"
        @@password-manager-open-tags-sidebar.window="tagsSidebarOpen = true"
    >
        <div
            id="password-manager-table"
            class="data-table-wrapper d-flex flex-column flex-grow-1 min-h-0"
            data-deleted-only="0"
            data-password-filter="all"
            :data-folder="(\$store.passwordManager && \$store.passwordManager.selectedFolderName) || ''"
        >
            <x-table
                search-class="password-manager-search"
                search-placeholder="Поиск по логину, ресурсу, тегу или названию"
                :data-table="$dataTable"
                :search-pilled="true"
                :has-sidebar="true"
                sidebar-label="Открыть"
            >
                <x-slot:filterSlot>
                    <div
                        class="password-manager-filter position-relative d-inline-block"
                        x-data="{
                            filterOpen: false,
                            filterOption: 'all',
                            options: [
                                { value: 'all', label: 'Показывать все пароли' },
                                { value: 'compromised', label: 'Скомпрометированные' },
                                { value: 'low_reliability', label: 'С низкой надежностью' },
                                { value: 'shared', label: 'Которыми поделились' }
                            ],
                            select(value) {
                                this.filterOption = value;
                                this.filterOpen = false;
                                const wrapper = document.getElementById('password-manager-table');
                                if (wrapper) {
                                    wrapper.setAttribute('data-password-filter', value);
                                    window.dispatchEvent(new CustomEvent('password-manager-reload-table'));
                                }
                            }
                        }"
                        @click.outside="filterOpen = false"
                    >
                        <button
                            type="button"
                            class="password-manager-filter__btn btn p-0 d-flex align-items-center justify-content-center border rounded"
                            aria-haspopup="listbox"
                            :aria-expanded="filterOpen"
                            @click="filterOpen = !filterOpen"
                        >
                            <x-icon name="menu_settings" :size="20" />
                            <span
                                class="password-manager-filter__badge position-absolute rounded-circle d-flex align-items-center justify-content-center"
                                x-show="filterOption !== 'all'"
                                x-cloak
                                x-text="1"
                            ></span>
                        </button>
                        <div
                            class="password-manager-filter__panel position-absolute end-0 mt-1 d-flex flex-column p-1"
                            x-show.important="filterOpen"
                            x-cloak
                            role="listbox"
                            aria-label="Фильтр паролей"
                        >
                            <template x-for="(opt, index) in options" :key="opt.value">
                                <div class="d-flex flex-column">
                                    <template x-if="index === 1">
                                        <div class="password-manager-filter__divider my-1"></div>
                                    </template>
                                    <button
                                        type="button"
                                        class="password-manager-filter__option d-flex align-items-center gap-2 w-100 border-0 text-start py-2 px-2 rounded"
                                        :class="{ 'password-manager-filter__option--selected': filterOption === opt.value }"
                                        role="option"
                                        :aria-selected="filterOption === opt.value"
                                        @click="select(opt.value)"
                                    >
                                        <span
                                            class="password-manager-filter__checkbox rounded flex-shrink-0 d-flex align-items-center justify-content-center"
                                            :class="{ 'password-manager-filter__checkbox--selected': filterOption === opt.value }"
                                        >
                                            <template x-if="filterOption === opt.value">
                                                <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg" class="password-manager-filter__check">
                                                    <path d="M1 3L3 5L7 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </template>
                                        </span>
                                        <span class="password-manager-filter__label" x-text="opt.label"></span>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </x-slot:filterSlot>
                <x-slot:search>
                    <div
                        class="password-manager-search-wrap position-relative d-flex flex-column"
                        data-autocomplete-url="{{ route('services.password-manager.autocomplete') }}"
                        x-data="passwordManagerSearch"
                    >
                        <div class="password-manager-search-bar d-flex flex-column gap-2 position-relative">
                            <div
                                class="input-body search-body search-body--lg search-box password-manager-search-bar__input-wrap position-relative"
                                :class="{ 'password-manager-search-bar__input-wrap--focus': dropdownOpen }"
                            >
                                <span class="input-icon search-icon" aria-hidden="true">
                                    <x-icon name="actions_search" :size="20" color="grey-3" />
                                </span>
                                <div class="search-content input-content d-flex align-items-center flex-nowrap gap-2 min-w-0">
                                    <template x-if="folderName">
                                        <span class="password-manager-search-chip password-manager-search-chip--folder tag tag--md tag--icon-right d-inline-flex align-items-center flex-nowrap">
                                            <x-icon name="document_folder" :size="20" class="me-1 password-manager-search-chip__folder-icon text-yellow" />
                                            <span class="tag-text text-truncate" style="max-width: 140px" x-text="folderName"></span>
                                            <span class="tag-icon tag-icon-right d-flex align-items-center justify-content-center" role="button" tabindex="0" @click.prevent="clearFolder()">
                                                <x-icon name="arrow_close" :size="20" />
                                            </span>
                                        </span>
                                    </template>
                                    <template x-if="tagName">
                                        <span class="password-manager-search-chip tag tag--md tag--icon-right d-inline-flex align-items-center flex-nowrap password-manager-search-chip--tag">
                                            <x-icon name="specific_tag" :size="20" class="me-1" />
                                            <span class="tag-text text-truncate" style="max-width: 120px" x-text="tagName"></span>
                                            <span class="tag-icon tag-icon-right d-flex align-items-center justify-content-center" role="button" tabindex="0" @click.prevent="clearTag()">
                                                <x-icon name="arrow_close" :size="20" />
                                            </span>
                                        </span>
                                    </template>
                                    <input
                                        type="search"
                                        class="input-field search-input flex-grow-1 min-w-0 border-0 bg-transparent"
                                        placeholder="Поиск по логину, ресурсу, тегу или названию"
                                        autocomplete="off"
                                        x-ref="searchInput"
                                        x-model="query"
                                        @input="onInput()"
                                        @blur="onBlur()"
                                    >
                                </div>
                                <span
                                    class="input-icon search-clear"
                                    role="button"
                                    tabindex="0"
                                    aria-label="Очистить"
                                    x-show="query !== ''"
                                    x-cloak
                                    @click="query = ''; dropdownOpen = false"
                                >
                                    <x-icon name="validation_cross_circle" :size="20" color="black" />
                                </span>
                            </div>
                            <div
                                class="password-manager-search-dropdown position-absolute start-0 end-0 mt-1 w-100 d-flex flex-column overflow-hidden"
                                x-show.important="showDropdown"
                                style="max-height: 320px; z-index: 10; top: 100%;"
                            >
                                <div class="password-manager-search-dropdown__panel bg-white rounded shadow-sm border">
                                    <button
                                        type="button"
                                        class="password-manager-search-dropdown__item password-manager-search-dropdown__item--show-all text-start border-0 w-100 py-2 px-3"
                                        @mousedown.prevent="onShowAll()"
                                    >
                                        <span class="small text-body" x-text="showAllLabel"></span>
                                    </button>
                                    <div class="password-manager-search-dropdown__divider"></div>
                                    <template x-for="(entry, i) in entries" :key="entry.id">
                                        <button
                                            type="button"
                                            class="password-manager-search-dropdown__item password-manager-search-dropdown__entry text-start border-0 w-100 py-2 px-3"
                                            :class="{ 'password-manager-search-dropdown__item--hover': hoverIndex === i }"
                                            @mousedown.prevent="onAddEntryToSearch(entry)"
                                            @mouseenter="hoverIndex = i"
                                            @mouseleave="hoverIndex = -1"
                                        >
                                            <div class="d-flex flex-column gap-0">
                                                <span class="password-manager-search-dropdown__label small text-secondary">Название</span>
                                                <span class="password-manager-search-dropdown__value fw-bold" x-text="entry.name"></span>
                                            </div>
                                            <template x-if="entry.url">
                                                <div class="d-flex flex-column gap-0 mt-1">
                                                    <span class="password-manager-search-dropdown__label small text-secondary">URL</span>
                                                    <span class="password-manager-search-dropdown__value" x-text="entry.url"></span>
                                                </div>
                                            </template>
                                            <template x-if="entry.tag">
                                                <div class="d-flex flex-column gap-0 mt-1">
                                                    <span class="password-manager-search-dropdown__label small text-secondary">Тег</span>
                                                    <span class="password-manager-search-dropdown__value" x-text="entry.tag"></span>
                                                </div>
                                            </template>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <span class="search-description mt-1" x-show="searchDescriptionText" x-text="searchDescriptionText"></span>
                    </div>
                </x-slot:search>
            </x-table>
        </div>

        <template x-if="{!! $pmAddSidebarOpen !!}">
            <x-right-sidebar
                :open="true"
                title=""
                :close-button-attributes="['x-on:click' => $pmCloseSidebar]"
                :overlay-attributes="['x-on:click.self' => $pmCloseSidebar]"
            >
                <x-slot:titleSlot>
                    <span x-text="{!! $pmTitleText !!}"></span>
                </x-slot:titleSlot>
                <div class="password-manager-form-sidebar d-flex flex-column gap-3">
                    <template x-if="{!! $pmEditEntryAlertBlock !!}">
                        <div class="d-flex flex-column gap-2 w-100">
                            <x-alert x-show="{!! $pmEditEntryWarning !!}" state="attention" class="mb-0" x-cloak>
                                <span x-text="{!! $pmEditEntryWarningText !!}"></span>
                            </x-alert>
                            <x-alert x-show="{!! $pmEditEntryAlert !!}" state="error" class="mb-0" x-cloak>
                                <span x-text="{!! $pmEditEntryAlertText !!}"></span>
                            </x-alert>
                        </div>
                    </template>
                    <section class="password-manager-form-sidebar__section">
                        <h4 class="password-manager-form-sidebar__section-title">Информация об элементе</h4>
                        <x-input name="name" placeholder="Название" x-model="{!! $pmFormName !!}" />
                        <x-select
                                name="folder"
                                placeholder="Папка"
                                leftIcon="document_folder"
                                :options="$folderSelectOptions"
                        />
                        <x-multiselect
                            name="tag"
                            placeholder="Тег"
                            search-placeholder="Выберите тег"
                            :options="$tagSelectOptions"
                            :selected="[]"
                            class="w-100"
                        />
                    </section>

                    <section class="password-manager-form-sidebar__section">
                        <h4 class="password-manager-form-sidebar__section-title">Данные для авторизации</h4>
                        <div class="d-flex flex-column gap-3">
                            <x-input name="url" placeholder="Сайт (URL)" x-model="{!! $pmFormUrl !!}" />
                            <div class="password-manager-form-sidebar__row d-flex flex-row">
                                <div class="password-manager-form-sidebar__half">
                                    <x-input type="stroke" name="login" placeholder="Логин" x-model="{!! $pmFormLogin !!}" />
                                </div>
                                <div
                                    class="password-manager-form-sidebar__half"
                                    x-data="{ showPassword: false }"
                                >
                                    <x-input
                                        type="stroke"
                                        name="password"
                                        placeholder="Пароль"
                                        inputType="password"
                                        x-model="{!! $pmFormPassword !!}"
                                    >
                                        <x-slot:rightIcons>
                                            <button
                                                type="button"
                                                class="password-manager-form-sidebar__icon-btn p-0 border-0 bg-transparent d-flex align-items-center justify-content-center"
                                                :aria-label="showPassword ? 'Скрыть пароль' : 'Показать пароль'"
                                                @click="showPassword = !showPassword; const inp = $el.closest('.password-manager-form-sidebar__half').querySelector('input[name=password]'); if (inp) inp.type = showPassword ? 'text' : 'password'"
                                            >
                                                <span x-show.important="!showPassword" class="d-inline-flex"><x-icon name="eye_alt" :size="20" /></span>
                                                <span x-show.important="showPassword" class="d-inline-flex" x-cloak><x-icon name="actions_eye_hide" :size="20" /></span>
                                            </button>
                                            <button
                                                type="button"
                                                class="password-manager-form-sidebar__icon-btn password-manager-form-sidebar__icon-btn--stroke p-0 border-0 bg-transparent d-flex align-items-center justify-content-center"
                                                aria-label="Сгенерировать пароль"
                                            >
                                                <x-icon name="arrow_refresh_2" :size="20" />
                                            </button>
                                        </x-slot:rightIcons>
                                    </x-input>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="password-manager-form-sidebar__section"
                        x-data="{ showMailInput: false }"
                    >
                        <h4 class="password-manager-form-sidebar__section-title">Предоставление доступа</h4>
                        <p class="password-manager-form-sidebar__section-desc mb-0">
                            Предоставьте доступ к паролю сотрудникам, зарегистрированным в аккаунте Коннектора, или отправить данные по электронной почте:
                        </p>
                        <div class="d-flex flex-column gap-2">
                            <x-multiselect
                                name="employees"
                                placeholder="Сотрудники"
                                search-placeholder="Добавить сотрудника"
                                :options="[]"
                                :selected="[]"
                                :allow-custom="true"
                                class="w-100"
                            />
                            <x-button
                                type="string"
                                icon-position="left"
                                size="small"
                                class="password-manager-form-sidebar__mail-btn align-self-start"
                                :extra-attributes="['x-on:click' => 'showMailInput = true; $nextTick(() => $refs.mailInput?.querySelector(\'input\')?.focus())']"
                            >
                                <x-slot:icon>
                                    <x-icon name="actions_mail" :size="16" />
                                </x-slot:icon>
                                Отправить по почте
                            </x-button>
                            <div
                                x-show="showMailInput"
                                x-cloak
                                class="password-manager-form-sidebar__mail-block w-100"
                                x-ref="mailInput"
                            >
                                <x-multiselect
                                    name="share_emails"
                                    placeholder="Email"
                                    search-placeholder="Добавить email"
                                    :options="[]"
                                    :selected="[]"
                                    :allow-custom="true"
                                    class="w-100 password-manager-form-sidebar__mail-multiselect"
                                >
                                    <x-slot:right>
                                        <x-tooltip
                                            text="Доступ будет отправлен после нажатия кнопки «Создать пароль»"
                                            bubbleVariant="pill"
                                        >
                                            <span class="d-flex align-items-center justify-content-center text-secondary" aria-hidden="true">
                                                <x-icon name="validation_info" :size="20" />
                                            </span>
                                        </x-tooltip>
                                    </x-slot:right>
                                </x-multiselect>
                            </div>
                        </div>
                    </section>
                </div>

                <x-slot:footer>
                    <x-button type="main" size="large">Сохранить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>

        <template x-if="tagsSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Управление тегами"
                :close-button-attributes="['x-on:click' => 'tagsSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'tagsSidebarOpen = false']"
            >
                <div class="password-manager-tags-sidebar d-flex flex-column gap-3" x-data="passwordManagerTagsSidebar()">
                    <div class="d-flex flex-row align-items-center gap-2 w-full">
                        <x-search placeholder="Найти тег" size="md" />
                        <x-button
                            type="stroke"
                            size="medium"
                            icon-position="only"
                            class="password-manager-sidebar__theme-btn rounded-circle p-2 flex-shrink-0"
                            :extra-attributes="[':class' => $tagsSidebarThemeBtnClassExpr, 'x-on:click' => 'tagsSidebarTagsColored = !tagsSidebarTagsColored']"
                        >
                            <x-slot:icon>
                                <x-icon name="actions_theme" :size="20" />
                            </x-slot:icon>
                        </x-button>
                    </div>
                    <div class="password-manager-tags-sidebar__list d-flex flex-column gap-2" x-ref="tagsList">
                        @foreach($tags as $tag)
                            @php
                                $tagName = is_array($tag) ? ($tag['name'] ?? '') : $tag;
                                $tagColor = is_array($tag) ? ($tag['color'] ?? null) : null;
                            @endphp
                            <div
                                class="password-manager-tags-sidebar__tag-row d-flex flex-row justify-content-between align-items-center rounded py-2 px-2"
                                data-tag-name="{{ e($tagName) }}"
                                x-data='{ tagColor: @json($tagColor) }'
                                {!! ' :class="' . e($tagsSidebarRowClassExpr) . '"' !!}
                                {!! ' :style="' . e($tagsSidebarRowStyleExpr) . '"' !!}
                            >
                                <div class="d-flex align-items-center gap-1 min-w-0 flex-grow-1">
                                    <x-drag-handle class="password-manager-tags-sidebar__tag-handle" />
                                    <span class="password-manager-tags-sidebar__tag-icon flex-shrink-0">
                                        <x-icon name="specific_tag" :size="20" />
                                    </span>
                                    <span class="text-truncate">{{ $tagName }}</span>
                                    @if($tagColor)
                                        <span
                                            class="password-manager-tags-sidebar__tag-color-chip flex-shrink-0 ms-auto me-1"
                                            style="background-color: {{ $tagColor }}; color: {{ $tagColor === '#FFCB66' ? '#141414' : '#FFFFFF' }}"
                                        >А</span>
                                    @endif
                                </div>
                                <div class="password-manager-tags-sidebar__tag-menu flex-shrink-0">
                                    <x-dropdown :items="$tagDropdownItems" :actions="true" class="dropdown-trigger-wrapper dropdown-root--align-right">
                                        <x-slot:trigger>
                                            <button type="button" class="btn p-2 border-0 rounded-circle" aria-label="Меню" aria-haspopup="menu">
                                                <x-icon name="arrow_three_dot_vertical" :size="20" />
                                            </button>
                                        </x-slot:trigger>
                                    </x-dropdown>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-right-sidebar>
        </template>

        <div
            x-show="$store.passwordManager.accessSidebarOpen"
            x-cloak
            style="display: none;"
        >
            <x-right-sidebar
                :open="true"
                title="Управление доступами"
                :close-button-attributes="['x-on:click' => $pmAccessCloseSidebar]"
                :overlay-attributes="['x-on:click.self' => $pmAccessCloseSidebar]"
            >
                <div
                    class="d-flex flex-column gap-3 password-manager-access-sidebar"
                    x-data="{ accessTab: 'sent' }"
                    @change="accessTab = $event.target.value; const el = document.getElementById('password-manager-access-table'); if (el) { el.setAttribute('data-access-type', $event.target.value); const t = el.querySelector('table'); if (t && window.$ && $(t).DataTable) $(t).DataTable().ajax.reload(); }"
                >
                    <x-button-toggle class="button-toggle--fill">
                        <x-button-toggle-item name="accessTab" value="sent" label="Отправленные мной" selected="sent" />
                        <x-button-toggle-item name="accessTab" value="received" label="Доступные мне" />
                    </x-button-toggle>
                    <div
                        id="password-manager-access-table"
                        class="data-table flex-grow-1 min-h-0 d-flex flex-column"
{{--                        :data-access-type="accessTab"--}}
                    >
                        <table
                            class="table password-manager-access-table"
                            data-options='@json($accessTableOptions)'
                            data-sidebar="true"
                            data-sidebar-label="Открыть"
                        ></table>
                    </div>
                </div>
            </x-right-sidebar>
        </div>
    </div>
@endsection

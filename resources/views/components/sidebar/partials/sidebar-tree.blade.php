@foreach($tree as $item)
    @if(! empty($item['children']))
        <div class="sidebar-item has-submenu">
            <x-sidebar.menu-item
                :text="$item['title']"
                :short-text="$item['attributes']['shortText'] ?? ''"
                :icon="$item['attributes']['icon'] ?? null"
                href="#"
                :has-children="true"
                :active="$item['active'] ?? false"
            />
            <div class="sidebar-submenu-dropdown">
                <x-sidebar.sidebar-submenu>
                    @foreach($item['children'] as $child)
                        <x-sidebar.menu-item
                            is-submenu
                            :text="$child['title']"
                            :href="$child['url'] ?? '#'"
                            :active="$child['active'] ?? false"
                        />
                    @endforeach
                </x-sidebar.sidebar-submenu>
            </div>
        </div>
    @else
        <div class="sidebar-item">
            <x-sidebar.menu-item
                :text="$item['title']"
                :short-text="$item['attributes']['shortText'] ?? ''"
                :icon="$item['attributes']['icon'] ?? null"
                :href="$item['url'] ?? '#'"
                :active="$item['active'] ?? false"
            />
        </div>
    @endif
@endforeach

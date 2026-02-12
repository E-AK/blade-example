<div {{ $attributes->merge([
    'class' => 'account-compact d-flex align-items-center gap-2 ' . $class
]) }}>
    <div class="position-relative account-avatar">
        <x-icon name="avatar" />

        @if($badge)
            <span class="p5 avatar-badge d-inline-flex align-items-center justify-content-center rounded-pill text-nowrap">
                {{ $badge }}
            </span>
        @endif
    </div>

    <div class="flex-grow-1 overflow-hidden d-flex flex-column gap-1 account-text">
        <div class="account-title text-truncate">
            {{ $title }}
        </div>

        <div class="p5 account-subtitle d-flex align-items-center gap-1 text-truncate">
            <span>{{ $subtitle }}</span>
            <x-icon name="actions_crown" />
        </div>
    </div>

    @if($hasChildren)
        <span class="menu-arrow d-flex align-items-center">
            <i class="bi bi-arrow-right-short menu-arrow-icon fs-4 lh-1"></i>
        </span>
    @endif
</div>

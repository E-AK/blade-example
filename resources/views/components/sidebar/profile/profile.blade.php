<div {{ $attributes->merge([
    'class' => 'account-compact d-flex align-items-center gap-2 ' . $class
]) }}>
    <div class="position-relative account-avatar">
        <div class="avatar-circle"></div>

        @if($badge)
            <span class="p5 avatar-badge">{{ $badge }}</span>
        @endif
    </div>

    <div class="flex-grow-1 overflow-hidden d-flex flex-column gap-1 account-text">
        <div class="account-title text-truncate">
            {{ $title }}
        </div>

        <div class="p5 account-subtitle d-flex align-items-center gap-1 text-truncate">
            <span>{{ $subtitle }}</span>
            <i class="bi bi-crown-fill account-crown"></i>
        </div>
    </div>

    <i class="bi bi-arrow-right-short menu-arrow-icon"></i>
</div>

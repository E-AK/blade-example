@php
    $tag = $href !== null ? 'a' : 'div';
    $wrapperAttrs = ['class' => 'user-card d-flex flex-row align-items-center p-3 gap-3 ' . $wrapperClass];
    if ($tag === 'a' && $href !== null) {
        $wrapperAttrs['href'] = $href;
        $wrapperAttrs['class'] .= ' text-decoration-none text-reset';
    }
@endphp
<{{ $tag }} @foreach($wrapperAttrs as $k => $v) {{ $k }}="{{ e($v) }}" @endforeach>
    <div class="user-card__avatar d-flex align-items-center justify-content-center rounded-2 flex-shrink-0">
        <x-icon name="avatar_2" :size="28" class="text-secondary" />
    </div>
    <div class="d-flex flex-column justify-content-center gap-1 flex-grow-1 min-w-0 user-card__body">
        <span class="fw-semibold text-body user-card__name">{{ $name }}</span>
        <div class="d-flex flex-row align-items-center gap-2 flex-wrap">
            @if($email !== '')
                <span class="text-secondary user-card__email">{{ $email }}</span>
            @endif
            <x-tag
                :text="$role"
                size="sm"
                icon="left"
                :left-icon="$tagLeftIcon"
                :hoverable="false"
                border-color="grey-4"
            />
        </div>
    </div>
    @if(isset($actions) && $actions->isNotEmpty())
        <div class="d-flex gap-2 flex-shrink-0">
            {{ $actions }}
        </div>
    @endif
</{{ $tag }}>

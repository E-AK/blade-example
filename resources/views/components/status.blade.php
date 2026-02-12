<div class="status d-flex justify-content-between {{ $colorClass() }}">
    <div class="dot-text d-flex align-items-center">
        <span class="status-dot"></span>
        <span class="status-text">{{ $text() }}</span>
    </div>
    @if($hasRightIcon)
        <x-icon :name="$icon()" :class="$colorClass()" />
    @endif
</div>
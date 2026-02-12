@props([
    'items' => [],
    'id' => 'dropdown',
])

<div class="custom-dropdown" id="{{ $id }}">
    @foreach($items as $item)
        <div class="dropdown-item
            {{ $item['state'] ?? 'default' }}
            {{ $item['icon'] ?? 'icon-none' }}">

            @if(isset($item['icon']) && in_array($item['icon'], ['left','both','controllers','label']))
                <div class="icon-left"></div>
            @endif

            <div class="item-label">{{ $item['label'] }}</div>

            @if(isset($item['icon']) && in_array($item['icon'], ['right','both']))
                <div class="icon-right"></div>
            @endif
                
            @if(isset($item['icon']) && in_array($item['icon'], ['controllers','label']))
                <div class="icon-controller"></div>
            @endif
        </div>
    @endforeach
</div>

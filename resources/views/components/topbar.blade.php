<div class="d-flex justify-content-between shadow topbar">
    <div class="d-flex flex-column gap-1">
        <span class="workspace-container-header-info">
            @if(! empty($breadcrumbs))
                @foreach($breadcrumbs as $index => $crumb)
                    @php
                        $lastPart = $crumb['title'];
                    @endphp
                    @if($index > 0)
                        <span class="workspace-container-header-info-sep" aria-hidden="true"> / </span>
                    @endif
                    @if($index < count($breadcrumbs) - 1)
                        @if(! empty($crumb['url']) && $crumb['url'] !== '#')
                            <a href="{{ $crumb['url'] }}" class="workspace-container-header-info-link">{{ $crumb['title'] }}</a>
                        @else
                            <span>{{ $crumb['title'] }}</span>
                        @endif
                    @else
                        <span>{{ $headerInfoText ?: $crumb['title'] }}</span>
                    @endif
                @endforeach
            @else
                {{ $headerInfoText }}
            @endif
        </span>
        <h1 class="workspace-container-header-title">
            {{ $headerTitleText ?: $lastPart ?? '' }}
        </h1>
    </div>
    @if($slot->isNotEmpty())
        <div class="right d-flex justify-content-center align-self-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
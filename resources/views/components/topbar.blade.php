<div class="d-flex justify-content-between shadow topbar">
    <div class="d-flex flex-column gap-1">
        <span class="workspace-container-header-info d-flex align-items-center small text-secondary">
            @if(! empty($breadcrumbs))
                @foreach($breadcrumbs as $index => $crumb)
                    @php
                        $lastPart = $crumb['title'];
                    @endphp
                    @if($index > 0 && ($index < count($breadcrumbs) - 1 || $showLastPart))
                        <span class="workspace-container-header-info-sep me-1 ms-1" aria-hidden="true"> / </span>
                    @endif
                    @if($index < count($breadcrumbs) - 1)
                        @if(! empty($crumb['url']) && $crumb['url'] !== '#')
                            <a href="{{ $crumb['url'] }}" class="workspace-container-header-info-link">{{ $crumb['title'] }}</a>
                        @else
                            <span>{{ $crumb['title'] }}</span>
                        @endif
                    @elseif($showLastPart)
                        <a href="{{ $lastBreadcrumbUrl ?? url()->previous() }}" class="workspace-container-header-info-link">{{ $headerInfoText ?: $crumb['title'] }}</a>
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
        <div class="right d-flex justify-content-center align-self-center gap-3">
            {{ $slot }}
        </div>
    @endif
</div>
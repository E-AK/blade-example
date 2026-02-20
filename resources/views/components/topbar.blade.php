<div class="d-flex justify-content-between shadow topbar">
    <div class="d-flex flex-column gap-1">
        <span class="workspace-container-header-info">
            @if(! empty($breadcrumbs))
                @foreach($breadcrumbs as $index => $crumb)
                    @if($index > 0)
                        <span class="workspace-container-header-info-sep" aria-hidden="true"> / </span>
                    @endif
                    @if(! empty($crumb['url']) && $crumb['url'] !== '#' && $index < count($breadcrumbs) - 1)
                        <a href="{{ $crumb['url'] }}" class="workspace-container-header-info-link">{{ $crumb['title'] }}</a>
                    @else
                        <span>{{ $crumb['title'] }}</span>
                    @endif
                @endforeach
            @else
                {{ $headerInfoText }}
            @endif
        </span>
        <h1 class="workspace-container-header-title">
            {{ $headerTitleText }}
        </h1>
    </div>
    <div class="right d-flex justify-content-center align-self-center gap-2">
        @if($showInfoButton)
            <x-button type="string" size="large" icon-position="left">
                <x-slot:icon>
                    <x-icon name="document_book" :size="20" />
                </x-slot:icon>
                {{ $infoButtonText }}
            </x-button>
        @endif
        @if($showSummaryButton)
            <x-button type="main" size="large">{{ $summaryButtonText }}</x-button>
        @endif
        @if($showActionButton)
            <x-button type="secondary" size="large" icon-position="right">
                {{ $actionButtonText }}
                <x-slot:icon>
                    <x-icon name="actions_share" :size="20" />
                </x-slot:icon>
            </x-button>
        @endif
    </div>
</div>
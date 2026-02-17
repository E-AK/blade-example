<div class="d-flex justify-content-between shadow topbar">
    <div class="d-flex flex-column gap-1">
        <span class="workspace-container-header-info">{{ $headerInfoText }}</span>
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
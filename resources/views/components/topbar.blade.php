<div class="d-flex justify-content-between shadow topbar">
    <div class="d-flex flex-column gap-1">
        <span class="workspace-container-header-info">{{ $headerInfoText }}</span>
        <h1 class="workspace-container-header-title">
            {{ $headerTitleText }}
        </h1>
    </div>
    <div class="right d-flex justify-content-center align-self-center">
        @if($showInfoButton)
            <x-button :text="$infoButtonText" icon-left='document_book' variant="string" size="lg"/>
        @endif
        @if($showSummaryButton)
            <x-button :text="$summaryButtonText" size="lg"/>
        @endif
        @if($showActionButton)
            <x-button :text="$actionButtonText" icon-right='actions_share' variant="secondary" size="lg"/>
        @endif
    </div>
</div>
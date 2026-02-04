<nav class="topbar py-3 px-4">
    <div class="rounded-4 shadow-sm px-4 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="mb-1 small text-muted">
                    {{ Breadcrumbs::render() }}
                </div>

                @if($title)
                    <h1 class="h2 fw-semibold mb-0">
                        @if($titleUrl)
                            <a href="{{ $titleUrl }}" class="text-decoration-none text-dark">
                                {{ $title }}
                            </a>
                        @else
                            {{ $title }}
                        @endif
                    </h1>
                @endif
            </div>

            <div class="d-flex justify-content-center align-items-center h-100">
                @if($createLabel)
                    <x-button :text="$createLabel" variant="danger-string" size="lg" />
                @endif
            </div>
        </div>
    </div>
</nav>

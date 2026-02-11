<div class="search-container {{ $description ? 'gap-2' : null }}">
    <div class="search-box input-group {{ $size === 'lg' ? 'search-box-lg' : 'search-box-md' }}">
        <span class="input-group-text search-icon">
            <i class="bi bi-search"></i>
        </span>

        <input
                type="text"
                class="form-control search-input"
                placeholder="{{ $placeholder }}"
                aria-label="Search"
        >

        <button class="input-group-text search-clear d-none" type="button">
            <i class="bi bi-x-circle-fill"></i>
        </button>
    </div>
    @if($description)
        <span class="description">{{$description}}</span>
    @endif
</div>

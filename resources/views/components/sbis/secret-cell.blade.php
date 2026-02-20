@props([
    'value' => '',
    'columnName' => 'Ключ',
])

@php
    $safeValue = e($value);
@endphp
<div
    class="sbis-secret-cell"
    x-data="{ masked: true, realValue: '{{ $safeValue }}', columnName: '{{ e($columnName) }}' }"
>
    <span class="sbis-secret-cell__text" x-show="masked" x-text="'********'"></span>
    <span class="sbis-secret-cell__text sbis-secret-cell__text--revealed" x-show="!masked" x-text="realValue"></span>
    <button
            type="button"
            class="sbis-secret-cell__btn btn btn-string btn--only btn--small border-0 p-0"
            @click="navigator.clipboard.writeText(realValue); if (window.Toast) window.Toast.success(columnName + ' скопирован');"
            aria-label="Копировать"
    >
        <svg width="20" height="20" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="sbis-secret-cell__icon"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.33333 2.5C3.33333 1.11929 4.45262 0 5.83333 0H10.2145C10.8775 0 11.5134 0.263392 11.9822 0.732233L14.2678 3.01777C14.7366 3.48661 15 4.12249 15 4.78553V10.8333C15 12.214 13.8807 13.3333 12.5 13.3333H11.6667V14.1667C11.6667 15.5474 10.5474 16.6667 9.16667 16.6667H2.5C1.11929 16.6667 0 15.5474 0 14.1667V5.83333C0 4.45262 1.11929 3.33333 2.5 3.33333H3.33333V2.5ZM3.33333 10.8333V5H2.5C2.03976 5 1.66667 5.3731 1.66667 5.83333V14.1667C1.66667 14.6269 2.03976 15 2.5 15H9.16667C9.6269 15 10 14.6269 10 14.1667V13.3333H5.83333C4.45262 13.3333 3.33333 12.214 3.33333 10.8333ZM10 1.83927V3.33334C10 4.25382 10.7462 5.00001 11.6667 5.00001H13.1607C13.532 5.00001 13.7179 4.5512 13.4554 4.28872L10.7113 1.54464C10.4488 1.28215 10 1.46806 10 1.83927Z" fill="currentColor"/></svg>
    </button>
    <button
            type="button"
            class="sbis-secret-cell__btn btn btn-string btn--only btn--small border-0 p-0"
            @click="masked = !masked"
            :aria-label="masked ? 'Показать' : 'Скрыть'"
    >
        <span x-show.important="masked" class="d-inline-flex sbis-secret-cell__icon-wrap"><svg width="20" height="20" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="sbis-secret-cell__icon"><path d="M8.33362 0C11.8637 0.000232194 14.9042 3.57393 16.2799 5.48828C16.795 6.2052 16.795 7.12879 16.2799 7.8457C14.9042 9.76006 11.8637 13.3338 8.33362 13.334C4.80337 13.334 1.76206 9.76009 0.386353 7.8457C-0.128789 7.12879 -0.128789 6.2052 0.386353 5.48828C1.76206 3.5739 4.80337 0 8.33362 0ZM8.33362 2.70898C6.04329 2.70898 4.18616 4.48087 4.18616 6.66699C4.18616 8.85316 6.04329 10.625 8.33362 10.625C10.6238 10.6248 12.4801 8.85305 12.4801 6.66699C12.4801 4.48098 10.6238 2.70916 8.33362 2.70898ZM8.33362 3.95898C9.90054 3.95916 11.1705 5.17135 11.1705 6.66699C11.1705 8.16263 9.90054 9.37482 8.33362 9.375C6.76654 9.375 5.49573 8.16274 5.49573 6.66699C5.49573 5.17124 6.76653 3.95898 8.33362 3.95898Z" fill="currentColor"/></svg></span>
        <span x-show.important="!masked" class="d-inline-flex sbis-secret-cell__icon-wrap"><svg width="20" height="20" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="sbis-secret-cell__icon"><path d="M4.58419 3.40431C2.48791 4.48635 1.16094 6.28934 0.501547 7.38887C0.149658 7.97563 0.149658 8.69103 0.501546 9.2778C1.49178 10.929 3.98753 14.1667 8.33339 14.1667C10.5106 14.1667 12.2235 13.3541 13.5153 12.3354L10.5902 9.41029C10.1878 10.2519 9.3285 10.8333 8.33339 10.8333C6.95268 10.8333 5.83339 9.71405 5.83339 8.33333C5.83339 7.33822 6.41479 6.47891 7.25643 6.07655L4.58419 3.40431Z" fill="currentColor"/><path d="M14.7352 11.1983C15.3746 10.5011 15.8474 9.80772 16.1652 9.2778C16.5171 8.69103 16.5171 7.97563 16.1652 7.38887C15.175 5.73767 12.6792 2.5 8.33339 2.5C7.60022 2.5 6.9197 2.59215 6.29019 2.75328L14.7352 11.1983Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M0.244078 0.244078C0.569515 -0.0813592 1.09715 -0.0813592 1.42259 0.244078L16.4226 15.2441C16.748 15.5695 16.748 16.0972 16.4226 16.4226C16.0972 16.748 15.5695 16.748 15.2441 16.4226L0.244078 1.42259C-0.0813592 1.09715 -0.0813592 0.569515 0.244078 0.244078Z" fill="currentColor"/></svg></span>
    </button>
</div>

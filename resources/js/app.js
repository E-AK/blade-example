import './bootstrap';
import $ from 'jquery';
import { Table } from './components/Table';

window.$ = window.jQuery = $;

$(document).ready(function () {
    const $layout = $('.app-layout');
    const $toggleBtn = $('.sidebar-toggle-btn');

    $toggleBtn.on('click', function () {
        $layout.toggleClass('is-collapsed');
    });
});

$(document).ready(function() {
    $('.select').on('click', function(e) {
        e.stopPropagation();

        if ($(this).hasClass('state-disabled')) return;

        const $wrapper = $(this).closest('.select-wrapper');
        const $dropdown = $wrapper.find('.select-dropdown');

        $('.select-wrapper .select-dropdown').not($dropdown).hide();
        $('.select-wrapper .select').not(this).removeClass('state-selected');

        $dropdown.toggle();
        $(this).toggleClass('state-selected');
    });

    $(document).on('click', function() {
        $('.select-dropdown').hide();
        $('.select').removeClass('state-selected');
    });

    $('.select-item').on('click', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const $wrapper = $item.closest('.select-wrapper');
        const $select = $wrapper.find('.select');

        $select.find('span').text($item.text());
        $wrapper.find('.select-dropdown').hide();
        $select.removeClass('state-selected');
    });
});

$('.sidebar-item.has-submenu').each(function () {
    const $item = $(this);
    const $dropdown = $item.find('.sidebar-submenu-dropdown');

    $item.on('mouseenter', function () {
        $dropdown.css('display', 'flex');

        const rect = $dropdown[0].getBoundingClientRect();
        const overflowBottom = rect.bottom > window.innerHeight;

        $dropdown.toggleClass('open-up', overflowBottom);
    });

    $item.on('mouseleave', function () {
        $dropdown.css('display', '');
        $dropdown.removeClass('open-up');
    });
});

$(document).ready(function () {
    $('.data-table').each((_, element) => {
        new Table(element);
    });
});

$(document).on('input', '.search-input', function () {
    const $box = $(this).closest('.search-box');
    const $clear = $box.find('.search-clear');

    if ($(this).val().length > 0) {
        $clear.removeClass('d-none');
    } else {
        $clear.addClass('d-none');
    }
});

$(document).on('click', '.search-clear', function () {
    const $box = $(this).closest('.search-box');
    const $input = $box.find('.search-input');

    $input.val('').trigger('input').focus();
});
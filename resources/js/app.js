import './bootstrap';
import $ from 'jquery';
import { Table } from './components/Table';

window.$ = window.jQuery = $;

$(document).ready(function () {
    const $layout = $('.app-layout');
    const $toggleBtn = $('.sidebar-toggle-btn');
    const $icon = $toggleBtn.find('i');

    $toggleBtn.on('click', function () {
        const isCollapsed = $layout.toggleClass('is-collapsed')
            .hasClass('is-collapsed');

        if (isCollapsed) {
            $icon
                .removeClass('bi-arrow-bar-left')
                .addClass('bi-arrow-bar-right');
        } else {
            $icon
                .removeClass('bi-arrow-bar-right')
                .addClass('bi-arrow-bar-left');
        }
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
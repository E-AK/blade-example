import './bootstrap';
import $ from 'jquery';
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
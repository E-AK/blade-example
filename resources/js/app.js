import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function () {
    const $layout = $('.app-layout');
    const $toggleBtn = $('.sidebar-toggle-btn');

    $toggleBtn.on('click', function () {
        const collapsed = $layout.toggleClass('is-collapsed').hasClass('is-collapsed');
    });
});
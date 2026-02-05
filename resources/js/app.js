import $ from 'jquery';
import './bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';
import Alpine from 'alpinejs'
import { Table } from './components/Table';

window.Alpine = Alpine

Alpine.start()

// Initialize DataTables for all tables with the 'data-table' class
$(document).ready(function () {
    $('.data-table').each((_, element) => {
        new Table(element);
    });
});

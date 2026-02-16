import './bootstrap';
import $ from 'jquery';

import initSidebar from './layout/sidebar';
import initSelect from './ui/select';
import initMultiselect from './ui/multiselect';
import initSearch from './ui/search';
import initToast from './ui/toast';
import initTables from './components/initTables';

window.$ = window.jQuery = $;

$(function () {
  initSidebar();
  initSelect();
  initMultiselect();
  initSearch();
  initToast();
  initTables();
});

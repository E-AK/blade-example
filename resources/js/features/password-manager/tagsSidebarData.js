/**
 * Alpine-данные сайдбара «Управление тегами» в менеджере паролей.
 * Один модуль — одна задача: инициализация DnD списка тегов.
 */

import { initPasswordManagerTagsSortable } from './sortable.js';

export function passwordManagerTagsSidebarData() {
  return {
    init() {
      this.$nextTick(() => {
        if (this.$refs.tagsList) {
          initPasswordManagerTagsSortable(this.$refs.tagsList);
        }
      });
    },
  };
}

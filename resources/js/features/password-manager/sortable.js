/**
 * DnD для списка папок и тегов менеджера паролей.
 * Один модуль — одна задача: инициализация Sortable и правила переноса.
 */

import Sortable from 'sortablejs';

const DROP_BEFORE_CLASS = 'password-manager-folder-item--drop-before';
const DROP_AFTER_CLASS = 'password-manager-folder-item--drop-after';
const DROP_INTO_CLASS = 'password-manager-folder-item--drop-into';
const DROP_BEFORE_FORBIDDEN_CLASS = 'password-manager-folder-item--drop-before-forbidden';
const DROP_AFTER_FORBIDDEN_CLASS = 'password-manager-folder-item--drop-after-forbidden';
const DROP_INTO_FORBIDDEN_CLASS = 'password-manager-folder-item--drop-into-forbidden';

export const ALL_DROP_INDICATOR_CLASSES = [
  DROP_BEFORE_CLASS,
  DROP_AFTER_CLASS,
  DROP_INTO_CLASS,
  DROP_BEFORE_FORBIDDEN_CLASS,
  DROP_AFTER_FORBIDDEN_CLASS,
  DROP_INTO_FORBIDDEN_CLASS,
];

export function removeDropIndicatorClasses(el) {
  if (el) {
    ALL_DROP_INDICATOR_CLASSES.forEach((c) => el.classList.remove(c));
  }
}

export function isDescendant(foldersFlat, folderId, ancestorId) {
  let current = foldersFlat.find((f) => f.id == folderId);
  while (current) {
    if (current.id == ancestorId) return true;
    current =
      current.parentId != null ? foldersFlat.find((f) => f.id == current.parentId) : null;
  }
  return false;
}

/**
 * Проверка: перенос перед/после запрещён (родитель в своего потомка).
 */
export function isDropForbidden(foldersFlat, draggedId, relatedEl) {
  if (!relatedEl?.dataset?.id || !foldersFlat.length) return false;
  const relatedFolder = foldersFlat.find((f) => f.id == relatedEl.dataset.id);
  if (!relatedFolder) return false;
  const relatedParentId = relatedFolder.parentId;
  if (relatedParentId == null) return false;
  return relatedParentId == draggedId || isDescendant(foldersFlat, relatedParentId, draggedId);
}

/**
 * Проверка: перенос «внутрь» папки запрещён (в себя или в своего потомка).
 */
export function isDropIntoForbidden(foldersFlat, draggedId, relatedEl) {
  if (!relatedEl?.dataset?.id || !foldersFlat.length) return false;
  const targetId = relatedEl.dataset.id;
  return targetId == draggedId || isDescendant(foldersFlat, targetId, draggedId);
}

/**
 * Инициализирует DnD для списка папок с подсветкой места вставки.
 * @param {HTMLElement} listEl - элемент <ul> со списком папок
 * @param {Array} foldersFlat - плоский список папок для проверки запрещённого переноса
 */
export function initPasswordManagerSortable(listEl, foldersFlat = []) {
  if (!listEl || listEl._sortable) {
    return;
  }

  let lastDropTarget = null;
  let lastValidDropTarget = null;
  let lastValidWillInsertAfter = null;

  Sortable.create(listEl, {
    animation: 150,
    handle: '.password-manager-folder-item__handle',
    filter: '.password-manager-folder-item--editing',
    ghostClass: 'password-manager-folder-item--ghost',
    dragClass: 'password-manager-folder-item--drag',
    onMove(evt) {
      removeDropIndicatorClasses(lastDropTarget);
      lastDropTarget = null;
      lastValidDropTarget = null;
      lastValidWillInsertAfter = null;

      const related = evt.related;
      if (!related?.classList?.contains('password-manager-folder-item')) return false;

      const draggedId = evt.dragged?.dataset?.id;
      const isParent = related.classList.contains('password-manager-folder-item--parent');
      const dropInto = isParent && evt.willInsertAfter;

      lastDropTarget = related;

      if (dropInto) {
        const forbiddenInto = draggedId && isDropIntoForbidden(foldersFlat, draggedId, related);
        related.classList.add(forbiddenInto ? DROP_INTO_FORBIDDEN_CLASS : DROP_INTO_CLASS);
        if (!forbiddenInto) {
          lastValidDropTarget = related;
          lastValidWillInsertAfter = true;
        }
      } else {
        const forbidden = draggedId && isDropForbidden(foldersFlat, draggedId, related);
        if (evt.willInsertAfter) {
          related.classList.add(forbidden ? DROP_AFTER_FORBIDDEN_CLASS : DROP_AFTER_CLASS);
        } else {
          related.classList.add(forbidden ? DROP_BEFORE_FORBIDDEN_CLASS : DROP_BEFORE_CLASS);
        }
        if (!forbidden) {
          lastValidDropTarget = related;
          lastValidWillInsertAfter = evt.willInsertAfter;
        }
      }

      return false;
    },
    onEnd(evt) {
      removeDropIndicatorClasses(lastDropTarget);
      lastDropTarget = null;

      const selector = ALL_DROP_INDICATOR_CLASSES.map((c) => '.' + c).join(', ');
      listEl.querySelectorAll(selector).forEach((el) => {
        ALL_DROP_INDICATOR_CLASSES.forEach((c) => el.classList.remove(c));
      });

      if (lastValidDropTarget && evt.item) {
        const refNode = lastValidWillInsertAfter
          ? lastValidDropTarget.nextElementSibling
          : lastValidDropTarget;
        if (refNode) {
          listEl.insertBefore(evt.item, refNode);
        } else {
          listEl.appendChild(evt.item);
        }
      }

      lastValidDropTarget = null;
      lastValidWillInsertAfter = null;
    },
  });
  listEl._sortable = true;
}

/**
 * Инициализирует DnD для списка тегов в сайдбаре «Управление тегами».
 * @param {HTMLElement} listEl - контейнер со строками тегов
 */
export function initPasswordManagerTagsSortable(listEl) {
  if (!listEl || listEl._sortable) {
    return;
  }
  Sortable.create(listEl, {
    animation: 150,
    handle: '.password-manager-tags-sidebar__tag-handle',
    ghostClass: 'password-manager-tags-sidebar__tag-row--ghost',
    dragClass: 'password-manager-tags-sidebar__tag-row--drag',
  });
}

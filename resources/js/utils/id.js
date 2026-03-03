/**
 * Генерирует короткий уникальный идентификатор для DOM/компонентов.
 * @param {string} [prefix=''] — префикс (например 'dropdown-', 'ms-')
 * @returns {string}
 */
export function uniqueId(prefix = '') {
  return `${prefix}${Math.random().toString(36).slice(2)}`;
}

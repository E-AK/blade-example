const DROPDOWN_SELECTORS = {
  wrapper: '.dropdown-trigger-wrapper',
  trigger: '.btn',
  menu: '.dropdown-menu.custom-dropdown',
};

const DROPDOWN_CLOSE_OTHERS_EVENT = 'dropdown-close-others';

export default function dropdown(Alpine) {
  Alpine.data('dropdown', () => ({
    _dropdownId: null,
    open: false,

    init() {
      this._dropdownId = `dropdown-${Math.random().toString(36).slice(2)}`;
    },

    openDropdown() {
      const trigger = this.$el.querySelector(DROPDOWN_SELECTORS.trigger);
      if (trigger?.classList.contains('disabled')) {
        return;
      }

      window.dispatchEvent(
        new CustomEvent(DROPDOWN_CLOSE_OTHERS_EVENT, { detail: this._dropdownId }),
      );
      this.open = true;
    },

    close() {
      this.open = false;
    },

    toggle() {
      this.open ? this.close() : this.openDropdown();
    },
  }));
}

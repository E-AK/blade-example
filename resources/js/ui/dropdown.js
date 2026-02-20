export default function dropdown(Alpine) {
  Alpine.data('dropdown', () => ({
    open: false,
    _dropdownId: null,

    init() {
      this._dropdownId = `dropdown-${Math.random().toString(36).slice(2)}`;
    },

    toggle() {
      this.open = !this.open;
      if (this.open) {
        window.dispatchEvent(
          new CustomEvent('dropdown-close-others', { detail: this._dropdownId })
        );
      }
    },

    close() {
      this.open = false;
    },
  }));

  Alpine.data('selectDropdown', () => ({
    open: false,
    _dropdownId: null,
    selectedValue: '',
    selectedLabel: '',
    placeholder: '',

    init() {
      this._dropdownId = `dropdown-${Math.random().toString(36).slice(2)}`;
      this.selectedValue = this.$el.dataset.initialValue ?? '';
      this.selectedLabel = this.$el.dataset.initialLabel ?? '';
      this.placeholder = this.$el.dataset.placeholder ?? '';
    },

    get displayText() {
      return this.selectedLabel || this.placeholder;
    },

    toggle() {
      this.open = !this.open;
      if (this.open) {
        window.dispatchEvent(
          new CustomEvent('dropdown-close-others', { detail: this._dropdownId })
        );
      }
    },

    close() {
      this.open = false;
    },

    selectOption(value, label) {
      this.selectedValue = value;
      this.selectedLabel = label;
      this.close();
    },
  }));
}

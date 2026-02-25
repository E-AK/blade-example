export default function dropdown(Alpine) {
  Alpine.data('dropdown', () => ({
    open: false,
    _dropdownId: null,
    panelStyle: {},

    init() {
      this._dropdownId = `dropdown-${Math.random().toString(36).slice(2)}`;
    },

    toggle() {
      this.open = !this.open;
      if (this.open) {
        window.dispatchEvent(
          new CustomEvent('dropdown-close-others', { detail: this._dropdownId })
        );
        this.$nextTick(() => {
          if (this.$el.dataset.panelMatchTrigger === 'true' && this.$refs.trigger && this.$refs.panel) {
            this.panelStyle = { width: `${this.$refs.trigger.offsetWidth}px` };
          }
        });
      } else {
        this.panelStyle = {};
      }
    },

    close() {
      if (!this.open) return;
      this.open = false;
      this.panelStyle = {};
      this.$el.classList.remove('dropdown-root--open-up', 'dropdown-root--align-right');
    },
  }));

  Alpine.data('selectDropdown', () => ({
    open: false,
    _dropdownId: null,
    panelStyle: {},
    selectedValue: '',
    selectedLabel: '',
    placeholder: '',

    init() {
      this._dropdownId = `dropdown-${Math.random().toString(36).slice(2)}`;
      this.selectedValue = this.$el.dataset.initialValue ?? '';
      this.selectedLabel = this.$el.dataset.initialLabel ?? '';
      this.placeholder = this.$el.dataset.placeholder ?? '';

      this._closeOthersHandler = (e) => {
        if (!document.contains(this.$el)) {
          window.removeEventListener('dropdown-close-others', this._closeOthersHandler);
          return;
        }
        if (e.detail !== this._dropdownId) {
          this.close();
        }
      };
      window.addEventListener('dropdown-close-others', this._closeOthersHandler);
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
        this.$nextTick(() => {
          const wrapper = this.$refs.selectWrapper;
          if (wrapper && this.$refs.panel) {
            this.panelStyle = { width: `${wrapper.offsetWidth}px` };
          }
        });
      } else {
        this.panelStyle = {};
      }
    },

    close() {
      this.open = false;
      this.panelStyle = {};
    },

    selectOption(value, label) {
      this.selectedValue = value;
      this.selectedLabel = label;
      this.close();
    },
  }));
}

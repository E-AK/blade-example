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
          this._applyPanelStyle();
        });
      } else {
        this.panelStyle = {};
      }
    },

    _applyPanelStyle() {
      if (!this.$refs.panel) return;
      const panel = this.$refs.panel;
      let style = {};
      if (this.$el.dataset.panelMatchTrigger === 'true' && this.$refs.trigger) {
        style.width = `${this.$refs.trigger.offsetWidth}px`;
      }
      const dataTable = this.$el.closest('.data-table');
      const contentInner = this.$el.closest('.content-inner');
      if (dataTable && contentInner) {
        const contentRect = contentInner.getBoundingClientRect();
        const paddingX = 20;
        const safeLeft = contentRect.left + paddingX;
        const safeRight = contentRect.right - paddingX;
        const panelRect = panel.getBoundingClientRect();
        const rootRect = this.$el.getBoundingClientRect();
        let panelLeft = panelRect.left;
        if (panelLeft < safeLeft) panelLeft = safeLeft;
        if (panelLeft + panelRect.width > safeRight) panelLeft = safeRight - panelRect.width;
        style.left = `${panelLeft - rootRect.left}px`;
        style.right = 'auto';
      }
      this.panelStyle = style;
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

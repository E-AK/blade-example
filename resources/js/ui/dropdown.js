const DROPDOWN_GAP = 4;
const DROPDOWN_PADDING = 16;

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
        document.body.style.overflow = 'hidden';
        this.$nextTick(() => this.positionPanel());
      } else {
        this.close();
      }
    },

    close() {
      if (!this.open) return;
      this.open = false;
      this.panelStyle = {};
      this.$el.classList.remove('dropdown-root--open-up', 'dropdown-root--align-right');
      document.body.style.overflow = '';
    },

    positionPanel() {
      const panel = this.$refs.panel;
      const trigger = this.$refs.trigger;
      if (!panel || !trigger) return;

      const triggerRect = trigger.getBoundingClientRect();
      const panelRect = panel.getBoundingClientRect();
      const panelWidth = panelRect.width;
      const panelHeight = panelRect.height;

      const spaceBelow = window.innerHeight - triggerRect.bottom - DROPDOWN_PADDING;
      const spaceAbove = triggerRect.top - DROPDOWN_PADDING;
      const openUp = spaceBelow < panelHeight && spaceAbove >= spaceBelow;

      let top = openUp
        ? triggerRect.top - DROPDOWN_GAP - panelHeight
        : triggerRect.bottom;
      top = Math.max(
        DROPDOWN_PADDING,
        Math.min(top, window.innerHeight - DROPDOWN_PADDING - panelHeight)
      );

      let left = triggerRect.left;
      const overflowRight = left + panelWidth > window.innerWidth - DROPDOWN_PADDING;
      if (overflowRight) {
        left = triggerRect.right - panelWidth;
      }
      left = Math.max(
        DROPDOWN_PADDING,
        Math.min(left, window.innerWidth - DROPDOWN_PADDING - panelWidth)
      );

      this.$el.classList.toggle('dropdown-root--open-up', openUp);
      this.$el.classList.toggle('dropdown-root--align-right', overflowRight);

      this.panelStyle = {
        position: 'fixed',
        left: `${left}px`,
        top: `${top}px`,
      };

      const inner = panel.querySelector('.dropdown-panel__inner');
      if (inner) {
        const maxHeight = openUp ? spaceAbove : spaceBelow;
        inner.style.maxHeight = `${Math.max(0, Math.min(320, maxHeight))}px`;
      }
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

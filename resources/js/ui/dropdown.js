import { uniqueId } from '../utils/id.js';

const DROPDOWN_PORTAL_ID = 'alpine-dropdown-teleport';

function getDropdownPortal() {
  let portal = document.getElementById(DROPDOWN_PORTAL_ID);
  if (!portal) {
    portal = document.createElement('div');
    portal.id = DROPDOWN_PORTAL_ID;
    portal.setAttribute('style', 'position:fixed;inset:0;pointer-events:none;z-index:1040;');
    document.body.appendChild(portal);
  }
  return portal;
}

export default function dropdown(Alpine) {
  Alpine.data('dropdown', () => ({
    open: false,
    _dropdownId: null,
    panelStyle: {},

    init() {
      this._dropdownId = uniqueId('dropdown-');
    },

    toggle(evt) {
      this.open = !this.open;
      if (this.open && evt && evt.currentTarget) {
        this._triggerEl = evt.currentTarget;
      }
      const dataTable = this.$el.closest('.data-table');
      if (this.open) {
        window.dispatchEvent(
          new CustomEvent('dropdown-close-others', { detail: this._dropdownId })
        );
        if (dataTable) dataTable.classList.add('data-table--dropdown-open');
        const isTeleport = this.$el.dataset.teleport === 'true';
        this.$nextTick(() => {
          requestAnimationFrame(() => {
            if (isTeleport) {
              this._applyPanelStyle();
              requestAnimationFrame(() => this._applyPanelStyle());
              setTimeout(() => this._applyPanelStyle(), 50);
            } else {
              this._applyPanelStyle();
            }
          });
        });
      } else {
        this.panelStyle = {};
        if (dataTable) {
          setTimeout(() => dataTable.classList.remove('data-table--dropdown-open'), 100);
        }
      }
    },

    _applyPanelStyle() {
      if (!this.$refs.panel) return;
      const panel = this.$refs.panel;
      const isTeleport =
        this.$el.dataset.teleport === 'true' || panel.parentNode === document.body;
      const trigger =
        this._triggerEl ||
        this.$refs.trigger ||
        this.$el.querySelector('.dropdown-trigger') ||
        this.$el.firstElementChild;
      let style = {};

      if (isTeleport && trigger) {
        const inBody = panel.parentNode === document.body;
        if (!inBody) {
          const portal = getDropdownPortal();
          if (panel.parentNode !== portal) {
            portal.appendChild(panel);
          }
        }

        const folderSource = this.$el.closest('[data-folder-id]');
        if (folderSource) {
          panel.dataset.folderId = folderSource.dataset.folderId ?? '';
          panel.dataset.folderName = folderSource.dataset.folderName ?? '';
          panel.dataset.folderDepth = folderSource.dataset.folderDepth ?? '';
          panel.dataset.folderPasswordsCount =
            folderSource.dataset.folderPasswordsCount ?? '';
        }

        const triggerRect = trigger.getBoundingClientRect();
        const alignRight = this.$el.classList.contains('dropdown-root--align-right');
        const openUp = this.$el.classList.contains('dropdown-root--open-up');
        const gap = 4;

        let leftPx = triggerRect.left;
        let topPx = triggerRect.bottom + gap;

        if (alignRight) {
          const panelWidth = panel.offsetWidth || panel.getBoundingClientRect().width;
          leftPx = panelWidth > 0 ? triggerRect.right - panelWidth : triggerRect.left;
        }
        if (openUp) {
          const panelHeight = panel.offsetHeight || panel.getBoundingClientRect().height;
          topPx =
            panelHeight > 0
              ? triggerRect.top - panelHeight - gap
              : triggerRect.top - 200 - gap;
        }

        style.position = 'fixed';
        style.left = `${leftPx}px`;
        style.top = `${topPx}px`;
        style.right = 'auto';
        style.bottom = 'auto';
        style.marginTop = '0';
        style.marginBottom = '0';

        panel.style.setProperty('position', 'fixed', 'important');
        panel.style.setProperty('left', `${leftPx}px`, 'important');
        panel.style.setProperty('top', `${topPx}px`, 'important');
        panel.style.setProperty('right', 'auto', 'important');
        panel.style.setProperty('bottom', 'auto', 'important');
        panel.style.setProperty('margin-top', '0', 'important');
        panel.style.setProperty('margin-bottom', '0', 'important');
        panel.style.setProperty('z-index', '1060', 'important');
        panel.style.setProperty('pointer-events', 'auto', 'important');
      } else {
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
      }
      this.panelStyle = style;
    },

    close() {
      if (!this.open) return;
      const panel = this.$refs.panel;
      const isTeleport = this.$el.dataset.teleport === 'true';
      const portal = document.getElementById(DROPDOWN_PORTAL_ID);
      const isInPortal = portal && panel && panel.parentNode === portal;
      const isInBody = panel && panel.parentNode === document.body;
      if (isTeleport && panel && isInPortal) {
        this.$el.appendChild(panel);
        panel.style.cssText = '';
      }
      this.open = false;
      this.panelStyle = {};
      if (isTeleport && panel) {
        panel.style.cssText = '';
      }
      this.$el.classList.remove('dropdown-root--open-up', 'dropdown-root--align-right');
      const dataTable = this.$el.closest('.data-table');
      if (dataTable) {
        setTimeout(() => dataTable.classList.remove('data-table--dropdown-open'), 100);
      }
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
      this._dropdownId = uniqueId('dropdown-');
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

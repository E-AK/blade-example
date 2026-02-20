const MULTISELECT_SELECTORS = {
  wrapper: '.multiselect-wrapper',
  trigger: '.multiselect-trigger',
  search: '.multiselect-search',
  input: '.multiselect-input',
  item: '.multiselect-item',
};

const DEFAULT_TAG_STYLE = {
  bg: 'grey-4',
  color: 'black',
  borderColor: 'grey-4',
};

export default function multiselect(Alpine) {
  Alpine.data('multiselect', () => ({
    open: false,
    searchQuery: '',
    selected: [],
    tagsSpacerWidth: 0,
    _msId: null,
    tagBg: DEFAULT_TAG_STYLE.bg,
    tagColor: DEFAULT_TAG_STYLE.color,
    tagBorderColor: DEFAULT_TAG_STYLE.borderColor,
    disabled: false,
    allowCustom: false,
    valueToLabel: null,

    init() {
      this._msId = `ms-${Math.random().toString(36).slice(2)}`;
      this.readDataset();
      this.buildValueToLabelMap();
      this.hydrateSelected();
      this.$watch('selected', this.onSelectedChange.bind(this), { deep: true });
      this.$watch('selected', () => this.$nextTick(() => this.updateTagsSpacerWidth()), {
        deep: true,
      });
      this.$nextTick(() => this.updateTagsSpacerWidth());
    },

    readDataset() {
      const { dataset } = this.$el;
      this.tagBg = dataset.tagBg || DEFAULT_TAG_STYLE.bg;
      this.tagColor = dataset.tagColor || DEFAULT_TAG_STYLE.color;
      this.tagBorderColor = dataset.tagBorderColor || DEFAULT_TAG_STYLE.borderColor;
      this.disabled = dataset.disabled === '1';
      this.allowCustom = dataset.allowCustom === '1';
    },

    addCustomIfAllowed() {
      if (!this.allowCustom || this.disabled) {
        return;
      }
      const query = (this.searchQuery || '').trim();
      if (!query || this.selected.includes(query)) {
        return;
      }
      this.selected.push(query);
      this.searchQuery = '';
      this.syncInput();
      this.updateClasses();
      this.updateAria();
      this.$nextTick(() => this.updateTagsSpacerWidth());
    },

    buildValueToLabelMap() {
      this.valueToLabel = new Map();
      this.$el.querySelectorAll(MULTISELECT_SELECTORS.item).forEach((el) => {
        const value = el.dataset.value;
        const label = (el.dataset.label ?? el.textContent ?? '').trim() || value;
        if (value !== null) {
          this.valueToLabel.set(String(value), label);
        }
      });
    },

    hydrateSelected() {
      const input = this.$el.querySelector(MULTISELECT_SELECTORS.input);
      if (input?.value) {
        this.selected = input.value
          .split(',')
          .map((v) => v.trim())
          .filter(Boolean);
      }
    },

    onSelectedChange() {
      this.syncInput();
      this.updateClasses();
      this.updateAria();
      this.$nextTick(() => this.updateTagsSpacerWidth());
    },

    updateTagsSpacerWidth() {
      const wrap = this.$refs.tagsWrap;
      this.tagsSpacerWidth = wrap ? wrap.offsetWidth : 0;
    },

    tagStyle() {
      const iconBlack = ['grey-4', 'yellow'].includes(this.tagBg);
      const styles = [
        `--tag-bg: var(--color-${this.tagBg})`,
        `--tag-color: var(--color-${this.tagColor})`,
        `--tag-border-color: var(--color-${this.tagBorderColor})`,
      ];
      if (iconBlack) {
        styles.push('--tag-icon-color: var(--color-black)');
      }
      return styles.join('; ');
    },

    getLabel(value) {
      return this.valueToLabel?.get(String(value)) ?? value;
    },

    openDropdown() {
      const trigger = this.$el.querySelector(MULTISELECT_SELECTORS.trigger);
      if (trigger?.classList.contains('disabled')) {
        return;
      }

      window.dispatchEvent(new CustomEvent('multiselect-close-others', { detail: this._msId }));
      this.open = true;
      this.searchQuery = '';
      this.updateAria();
      this.$nextTick(() => {
        const search = this.$el.querySelector(MULTISELECT_SELECTORS.search);
        search?.focus();
        this.filterDropdown();
      });
    },

    close() {
      this.open = false;
    },

    toggle() {
      this.open ? this.close() : this.openDropdown();
    },

    isSelected(value) {
      return this.selected.includes(String(value));
    },

    toggleOption(el) {
      const value = String(el.dataset.value ?? '');
      if (!value) {
        return;
      }

      if (this.selected.includes(value)) {
        this.removeTag(value);
      } else {
        this.selected.push(value);
      }
      this.syncInput();
      this.updateClasses();
      this.$nextTick(() => this.updateAria());
    },

    removeTag(value) {
      const strValue = String(value);
      this.selected = this.selected.filter((v) => String(v) !== strValue);
      this.syncInput();
      this.updateClasses();
      this.updateAria();
    },

    syncInput() {
      const input = this.$el.querySelector(MULTISELECT_SELECTORS.input);
      if (input) {
        input.value = this.selected.join(',');
      }
    },

    updateClasses() {
      const trigger = this.$el.querySelector(MULTISELECT_SELECTORS.trigger);
      const search = this.$el.querySelector(MULTISELECT_SELECTORS.search);
      if (trigger) {
        trigger.classList.toggle('multiselect--filled', this.selected.length >= 2);
      }
      if (search) {
        search.placeholder =
          this.selected.length >= 1 ? search.dataset.searchPlaceholder : search.dataset.placeholder;
      }
    },

    updateAria() {
      this.$el.querySelectorAll(MULTISELECT_SELECTORS.item).forEach((el) => {
        const value = el.dataset.value !== null ? String(el.dataset.value) : '';
        const selected = this.isSelected(value);
        el.setAttribute('aria-selected', selected ? 'true' : 'false');
        el.classList.toggle('multiselect-item--selected', selected);
      });
    },

    filterDropdown() {
      const search = this.$el.querySelector(MULTISELECT_SELECTORS.search);
      const query = (search?.value ?? this.searchQuery ?? '').trim().toLowerCase();
      this.$el.querySelectorAll(MULTISELECT_SELECTORS.item).forEach((el) => {
        const label = (el.dataset.label ?? el.textContent ?? '').trim().toLowerCase();
        const hidden = query.length > 0 && !label.includes(query);
        el.classList.toggle('multiselect-item--hidden', hidden);
      });
    },
  }));
}

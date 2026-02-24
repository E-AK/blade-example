export default function multiselect(Alpine) {
  Alpine.data('multiselectDropdownItems', () => ({
    selectedValues: [],
    init() {
      const id =
        this.$el.dataset.multiselectOptionsId ||
        this.$el.closest('[data-multiselect-id]')?.dataset?.multiselectId ||
        '';
      if (!id) return;
      this.$watch(
        () => Alpine.store('multiselectState'),
        (store) => {
          const raw = store?.[id] || [];
          this.selectedValues = Array.isArray(raw) ? raw.map((v) => String(v)) : [];
        },
        { immediate: true, deep: true }
      );
    },
  }));

  Alpine.data('multiselect', () => ({
    options: {},
    selected: [],
    searchQuery: '',
    tagsSpacerWidth: 0,
    disabled: false,
    tagBg: 'grey-4',
    tagColor: 'black',
    tagBorderColor: 'grey-4',

    init() {
      const el = this.$el;
      this.options = JSON.parse(el.dataset.options || '{}');
      const rawSelected = JSON.parse(el.dataset.selected || '[]');
      this.selected = Array.isArray(rawSelected) ? rawSelected.map((v) => String(v)) : [];
      this.disabled = el.dataset.disabled === '1';
      this.tagBg = el.dataset.tagBg || 'grey-4';
      this.tagColor = el.dataset.tagColor || 'black';
      this.tagBorderColor = el.dataset.tagBorderColor || 'grey-4';
      const existingId = el.dataset.multiselectId?.trim();
      this.id = existingId || `ms-${Math.random().toString(36).slice(2)}`;
      if (!existingId) el.dataset.multiselectId = this.id;
      if (typeof Alpine.store('multiselectState') === 'undefined') {
        Alpine.store('multiselectState', {});
      }
      this.syncStore();
      this.$watch('selected', () => {
        this.updateTagsSpacerWidth();
        this.syncStore();
      }, { deep: true });
      this.$nextTick(() => this.updateTagsSpacerWidth());
    },

    syncStore() {
      const state = Alpine.store('multiselectState') || {};
      Alpine.store('multiselectState', { ...state, [this.id]: [...this.selected] });
    },

    toggleOption(value) {
      if (this.disabled) return;
      const str = String(value);
      const idx = this.selected.indexOf(str);
      if (idx === -1) {
        this.selected.push(str);
      } else {
        this.selected.splice(idx, 1);
      }
    },

    removeTag(value) {
      this.toggleOption(value);
    },

    getLabel(value) {
      const opt = this.options[value];
      if (opt == null) return String(value);
      return typeof opt === 'object' && opt !== null && 'label' in opt
        ? (opt.label ?? String(value))
        : String(opt);
    },

    tagStyle(value) {
      const opt = this.options[value];
      const tag = typeof opt === 'object' && opt !== null && opt.tag ? opt.tag : null;
      const bg = tag?.bg ?? this.tagBg;
      const color = tag?.color ?? this.tagColor;
      const borderColor = tag?.borderColor ?? this.tagBorderColor;
      return {
        '--tag-bg': `var(--color-${bg}, var(--color-grey-4))`,
        '--tag-color': `var(--color-${color}, var(--color-black))`,
        '--tag-border-color': `var(--color-${borderColor}, var(--color-grey-4))`,
      };
    },

    updateTagsSpacerWidth() {
      this.$nextTick(() => {
        const wrap = this.$refs.tagsWrap;
        this.tagsSpacerWidth = wrap ? wrap.offsetWidth : 0;
      });
    },
  }));
}

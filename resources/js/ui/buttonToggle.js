export default function buttonToggle(Alpine) {
  Alpine.data('buttonToggle', () => ({
    selected: null,

    init() {
      this.syncState();
    },

    syncState() {
      const radio = this.$el.querySelector('input:checked');
      this.selected = radio ? radio.value : null;
    },
  }));
}

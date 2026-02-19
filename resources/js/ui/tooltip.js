const TOOLTIP_GAP = 8;

export default function tooltip(Alpine) {
  Alpine.data('tooltip', () => ({
    open: false,
    bubbleStyle: {},

    updatePosition() {
      if (!this.$refs.trigger) {
        return;
      }

      const r = this.$refs.trigger.getBoundingClientRect();
      const bubble = this.$refs.bubble;
      const bubbleHeight = bubble ? bubble.offsetHeight : 32;
      const bubbleWidth = bubble ? bubble.offsetWidth : 200;

      const overflowBottom = r.bottom + TOOLTIP_GAP + bubbleHeight > window.innerHeight;
      const overflowTop = r.top - TOOLTIP_GAP - bubbleHeight < 0;

      let top;
      let transform;
      if (overflowTop && !overflowBottom) {
        top = r.bottom + TOOLTIP_GAP;
        transform = 'translate(-50%, 0)';
      } else {
        top = r.top - TOOLTIP_GAP - bubbleHeight;
        transform = 'translate(-50%, 0)';
      }

      const centerX = r.left + r.width / 2;
      const left = Math.max(
        bubbleWidth / 2,
        Math.min(centerX, window.innerWidth - bubbleWidth / 2)
      );

      this.bubbleStyle = {
        left: `${left}px`,
        top: `${top}px`,
        transform,
      };
    },
  }));
}

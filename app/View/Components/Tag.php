<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tag extends Component
{
    private const SIZES = [
        'sm' => 'tag--sm',
        'md' => 'tag--md',
        'lg' => 'tag--lg',
    ];

    private const ICON_VARIANTS = [
        'none' => '',
        'left' => 'tag--icon-left',
        'right' => 'tag--icon-right',
        'both' => 'tag--icon-both',
    ];

    public function __construct(
        public string $text = '',
        public string $size = 'md',
        public string $icon = 'none',
        public bool $selected = false,
        public bool $disabled = false,
        public bool $hoverable = true,
        public string $bg = 'white',
        public string $color = 'black',
        public string $borderColor = 'grey-4',
        public string $hoverBg = 'green',
        public string $hoverColor = 'white',
        public string $hoverBorderColor = 'green',
        public string $borderStyle = 'solid',
        public string $leftIcon = 'specific_tag',
        public string $rightIcon = 'arrow_close',
        public array $rightIconAttributes = [],
        public string $class = '',
    ) {}

    public function classes(): string
    {
        $base = ['tag'];

        $base[] = self::SIZES[$this->size] ?? self::SIZES['md'];

        if (isset(self::ICON_VARIANTS[$this->icon])) {
            $base[] = self::ICON_VARIANTS[$this->icon];
        }

        if ($this->hoverable && ! $this->disabled) {
            $base[] = 'tag--hoverable';
        }

        if ($this->selected) {
            $base[] = 'is-selected';
        }

        if ($this->disabled) {
            $base[] = 'is-disabled';
        }

        $base[] = 'border-'.$this->borderStyle;

        $base[] = $this->class;

        return implode(' ', array_filter($base));
    }

    public function inlineStyles(): string
    {
        $styles = [];

        if ($this->bg) {
            $styles[] = "--tag-bg: var(--color-$this->bg);";
        }
        if ($this->color) {
            $styles[] = "--tag-color: var(--color-$this->color);";
        }
        if ($this->borderColor) {
            $styles[] = "--tag-border-color: var(--color-$this->borderColor);";
        }

        if ($this->hoverBg) {
            $styles[] = "--tag-hover-bg: var(--color-$this->hoverBg);";
        }
        if ($this->hoverColor) {
            $styles[] = "--tag-hover-color: var(--color-$this->hoverColor);";
        }
        if ($this->hoverBorderColor) {
            $styles[] = "--tag-hover-border-color: var(--color-$this->hoverBorderColor);";
        }

        $iconColor = in_array($this->bg, ['grey-4', 'yellow'], true)
            ? 'black'
            : ($this->bg === 'white' ? 'grey-2' : 'white');
        $styles[] = "--tag-icon-color: var(--color-$iconColor);";

        return implode(' ', $styles);
    }

    public function hasLeftIcon(): bool
    {
        return in_array($this->icon, ['left', 'both']);
    }

    public function hasRightIcon(): bool
    {
        return in_array($this->icon, ['right', 'both']);
    }

    public function iconSize(): int
    {
        return match ($this->size) {
            'sm' => 16,
            default => 20,
        };
    }

    public function leftIconName(): string
    {
        return $this->leftIcon;
    }

    public function rightIconName(): string
    {
        return $this->rightIcon;
    }

    /**
     * Render the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tag');
    }
}

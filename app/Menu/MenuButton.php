<?php

namespace App\Menu;

use Illuminate\Support\Facades\Blade;
use Spatie\Menu\Activatable;
use Spatie\Menu\Item;

class MenuButton implements Item, Activatable
{
    protected bool $active = false;
    protected bool $exactActive = false;

    public function __construct(
        protected string $text,
        protected array $props = []
    ) {}

    public static function make(string $text, array $props = []): self
    {
        return new self($text, $props);
    }

    public function setActive(bool | callable $active = true): static
    {
        $this->active = $active;
        return $this;
    }

    public function setExactActive(bool $active = true): self
    {
        $this->exactActive = $active;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isExactActive(): bool
    {
        return $this->exactActive;
    }

    public function render(): string
    {
        $class = ($this->props['class'] ?? '') . ($this->active ? ' active' : '');

        $props = array_merge($this->props, ['class' => trim($class)]);

        $attributes = collect($props)
            ->map(fn ($v, $k) => is_bool($v)
                ? ($v ? $k : '')
                : $k.'="'.e($v).'"')
            ->filter()
            ->implode(' ');

        return Blade::render("<x-button {$attributes}>{$this->text}</x-button>");
    }

    public function setInactive(): static
    {
        return $this;
    }

    public function url(): string|null
    {
        return null;
    }

    public function hasUrl(): bool
    {
        return false;
    }

    public function setUrl(?string $url): static
    {
        return $this;
    }

    public function determineActiveForUrl(string $url, string $root = '/'): void
    {
        //
    }
}
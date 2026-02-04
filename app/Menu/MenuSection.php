<?php

namespace App\Menu;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Menu\Activatable;
use Spatie\Menu\Item;

class MenuSection implements Item, Activatable
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function url(): ?string
    {
        return $this->props['href'] ?? null;
    }

    public function hasUrl(): bool
    {
        return isset($this->props['href']);
    }

    public function setUrl(?string $url): static
    {
        $this->props['href'] = $url;
        return $this;
    }

    public function determineActiveForUrl(string $url, string $root = '/'): void
    {
        // @TODO: active by url
    }

    public function render(): string
    {
        return Blade::render(
            <<<'BLADE'
<x-menu-section
    :text="$text"
    :icon="$icon ?? null"
    :href="$href ?? '#'"
    :active="$active"
    :has-children="$hasChildren ?? false"
/>
BLADE,
            array_merge($this->props, [
                'text'   => $this->text,
                'active' => $this->active,
            ])
        );
    }

    public function setInactive(): static
    {
        $this->active = false;
        return $this;
    }
}

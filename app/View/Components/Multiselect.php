<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Multiselect extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $placeholder = 'Сотрудники',
        public ?string $searchPlaceholder = 'Поиск...',
        public ?string $leftIcon = null,
        public array $options = [],
        public array $selected = [],
        public bool $disabled = false,
        public ?string $error = null,
        public ?string $state = null,
        public bool $showRightIcon = false,
        public string $tagBg = 'grey-4',
        public string $tagColor = 'black',
        public string $tagBorderColor = 'grey-4',
        public string $class = '',
        public bool $allowCustom = false,
    ) {}

    /**
     * Get selected option labels for display.
     *
     * @return array<int, array{value: string, label: string, tag?: array{bg?: string, color?: string, borderColor?: string}}>
     */
    public function selectedOptions(): array
    {
        $result = [];
        foreach ($this->selected as $value) {
            $opt = $this->options[$value] ?? null;
            if (is_array($opt)) {
                $result[] = [
                    'value' => (string) $value,
                    'label' => $opt['label'] ?? (string) $value,
                    'tag' => $opt['tag'] ?? null,
                ];
            } else {
                $result[] = ['value' => (string) $value, 'label' => $opt ?? (string) $value];
            }
        }

        return $result;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.multiselect');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\DataTables\PasswordManagerAccessDataTable;
use App\DataTables\PasswordManagerDataTable;
use App\Http\Controllers\Controller;
use App\Models\PasswordManagerEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordManagerController extends Controller
{
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $folder = $request->input('folder');
        $limit = min((int) $request->input('limit', 10), 20);

        $entries = PasswordManagerEntry::query()
            ->whereNull('deleted_at')
            ->when(
                is_string($folder) && $folder !== '',
                fn ($q) => $q->where('folder', $folder)
            )
            ->when(
                $query !== '',
                fn ($q) => $q->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%'.$query.'%')
                        ->orWhere('url', 'like', '%'.$query.'%')
                        ->orWhere('login', 'like', '%'.$query.'%');
                })
            )
            ->orderBy('name')
            ->limit($limit)
            ->get(['id', 'name', 'url', 'folder', 'login']);

        $total = 0;
        if ($query !== '') {
            $total = PasswordManagerEntry::query()
                ->whereNull('deleted_at')
                ->when(
                    is_string($folder) && $folder !== '',
                    fn ($q) => $q->where('folder', $folder)
                )
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%'.$query.'%')
                        ->orWhere('url', 'like', '%'.$query.'%')
                        ->orWhere('login', 'like', '%'.$query.'%');
                })
                ->count();
        }

        return response()->json([
            'total' => $total,
            'entries' => $entries->map(fn (PasswordManagerEntry $e) => [
                'id' => $e->id,
                'name' => $e->name,
                'url' => $e->url ?? '',
                'folder' => $e->folder ?? '',
                'login' => $e->login ?? '',
                'tag' => '',
                'tags' => [],
            ]),
        ]);
    }

    public function index(PasswordManagerDataTable $dataTable, PasswordManagerAccessDataTable $accessDataTable)
    {
        $folders = $this->getFolders();
        $tags = $this->getTags();

        return $dataTable->render('pages.services.password-manager', [
            'folders' => $folders,
            'tags' => $tags,
            'accessDataTable' => $accessDataTable,
        ]);
    }

    public function accessData(PasswordManagerAccessDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Дерево папок для тестирования всех состояний: выбор, раскрытие, подпапки, ховеры, DnD.
     *
     * @return array<int, array{id: string, name: string, depth: int, parentId: ?string, hasChildren: bool}>
     */
    private function getFolders(): array
    {
        $tree = [
            [
                'id' => '1',
                'name' => 'Папка №1',
                'children' => [],
            ],
            [
                'id' => '2',
                'name' => 'Пароли от акаунтов',
                'passwordsCount' => 7,
                'children' => [
                    ['id' => '2-1', 'name' => 'Аккаунт ID-12', 'children' => []],
                    ['id' => '2-2', 'name' => 'Аккаунт ID-4', 'children' => []],
                    ['id' => '2-3', 'name' => 'Аккаунт ID-6', 'children' => []],
                    ['id' => '2-4', 'name' => 'Аккаунт ID-7', 'children' => []],
                ],
            ],
            [
                'id' => '3',
                'name' => 'Длинное название папки с большим количеством текста для проверки обрезки',
                'children' => [],
            ],
            [
                'id' => '4',
                'name' => 'Клиентские пароли',
                'children' => [],
            ],
            [
                'id' => '5',
                'name' => '(неактуальные)',
                'children' => [],
            ],
            [
                'id' => '6',
                'name' => 'Архив',
                'children' => [
                    ['id' => '6-1', 'name' => 'Старые пароли', 'children' => []],
                    ['id' => '6-2', 'name' => 'Резервные копии', 'children' => []],
                ],
            ],
            [
                'id' => '7',
                'name' => 'Общие доступы',
                'children' => [
                    ['id' => '7-1', 'name' => 'Команда продаж', 'children' => []],
                    ['id' => '7-2', 'name' => 'Команда поддержки', 'children' => []],
                ],
            ],
            [
                'id' => '8',
                'name' => 'Дополнительная папка для скролла 1',
                'children' => [],
            ],
            [
                'id' => '9',
                'name' => 'Дополнительная папка для скролла 2',
                'children' => [],
            ],
            [
                'id' => '10',
                'name' => 'Дополнительная папка для скролла 3',
                'children' => [],
            ],
        ];

        return $this->flattenFoldersTree($tree, 0, null);
    }

    /**
     * @param  array<int, array{id: string, name: string, children: array, passwordsCount?: int}>  $tree
     * @return array<int, array{id: string, name: string, depth: int, parentId: ?string, hasChildren: bool, passwordsCount: int}>
     */
    private function flattenFoldersTree(array $tree, int $depth, ?string $parentId): array
    {
        $flat = [];
        foreach ($tree as $node) {
            $children = $node['children'] ?? [];
            $flat[] = [
                'id' => $node['id'],
                'name' => $node['name'],
                'depth' => $depth,
                'parentId' => $parentId,
                'hasChildren' => count($children) > 0,
                'passwordsCount' => $node['passwordsCount'] ?? 0,
            ];
            $flat = array_merge(
                $flat,
                $this->flattenFoldersTree($children, $depth + 1, $node['id'])
            );
        }

        return $flat;
    }

    /**
     * @return array<int, array{name: string, color: string}>
     */
    private function getTags(): array
    {
        return [
            ['name' => 'Рабочие', 'color' => '#33B868'],
            ['name' => 'Личные', 'color' => '#FFCB66'],
            ['name' => 'Банки', 'color' => '#3090F0'],
            ['name' => 'Соцсети', 'color' => '#EB4B4B'],
        ];
    }
}

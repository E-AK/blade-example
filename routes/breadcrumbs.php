<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('settings.index', static fn (BreadcrumbTrail $trail) => $trail->push('Настройки', route('settings.index')));

Breadcrumbs::for('settings.account', static fn (BreadcrumbTrail $trail) => $trail->parent('settings.index')
    ->push('Настройки аккаунта', route('settings.account'))
);

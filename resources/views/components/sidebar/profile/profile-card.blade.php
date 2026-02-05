<div>
    <div {{ $attributes->merge(['class' => 'profile-card d-flex flex-column gap-3 ' . $class]) }}>
        <x-profile
                title="ООО Сбис-Вятка"
                subtitle="Иванов В. В."
                badge="24"
        />

        <x-balance />
    </div>
</div>
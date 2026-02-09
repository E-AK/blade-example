<div>
    <div {{ $attributes->merge(['class' => 'profile-card d-flex flex-column gap-3 ' . $class]) }}>
        <x-profile.profile
            :title="$title"
            :subtitle="$subtitle"
            :badge="$badge"
        />

        <x-profile.balance
            :balance="$balance"
        />
    </div>
</div>
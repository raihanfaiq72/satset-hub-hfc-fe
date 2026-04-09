<template id="tpl-step-2">
    <div class="space-y-6">
        <div id="addressList" class="space-y-4">
            @if (isset($user_locations) && count($user_locations) > 0)
                @foreach ($user_locations as $loc)
                    @include('services.partials.address_card', [
                        'value' => $loc['Id'],
                        'title' => $loc['NamaLokasi'],
                        'desc' => $loc['alamat'],
                        'icon' => 'home',
                        'isSelected' => false,
                    ])
                @endforeach
            @endif

            @include('services.partials.address_card', [
                'value' => 'new',
                'title' => 'Gunakan Alamat Baru',
                'icon' => 'plus',
                'isSelected' => false,
            ])
        </div>
    </div>
</template>

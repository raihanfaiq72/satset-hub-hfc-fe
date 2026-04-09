<template id="tpl-step-2">
    <div class="space-y-6">
        <div id="addressList" class="space-y-4">
            <!-- Address cards will be injected by JS -->
        </div>
    </div>
</template>

<template id="tpl-address-card">
    <label class="address-card flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer">
        <input type="radio" name="address" class="radio-custom">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="addr-icon"></span>
                <span class="addr-title font-bold text-gray-800"></span>
            </div>
            <p class="addr-desc text-xs text-gray-500"></p>
        </div>
    </label>
</template>

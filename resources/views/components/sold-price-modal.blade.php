<div x-data="{ show: false, soldPrice: '' }" x-show="show" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 text-gray-900">Registrar valor de venta</h2>
        <form @submit.prevent="$dispatch('sold-price-submitted', { soldPrice }); show = false; soldPrice = ''">
            <label class="block text-sm font-semibold mb-2 text-gray-700">¿A qué valor se vendió el vehículo?</label>
            <input type="number" min="0" step="1000" x-model="soldPrice" required class="w-full h-12 px-4 border border-gray-300 rounded-lg text-sm mb-4 focus:outline-none focus:border-blue-500" placeholder="$50.000.000">
            <div class="flex justify-end gap-2">
                <button type="button" @click="show = false" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>
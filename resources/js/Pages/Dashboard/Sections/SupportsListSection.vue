<script setup>
// Reciben los supports como array
const props = defineProps({
    supports: {
        type: Array,
        default: () => []
    }
});

// Helper para formatear montos en CLP
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP',
        maximumFractionDigits: 0
    }).format(amount);
};

// Helper para formatear fechas en formato legible
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('es-CL', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};
</script>

<template>
    <div class="rounded-xl bg-white p-6 shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Apoyos recibidos</h3>
        
        <p class="text-sm text-gray-500 mb-6">
            Aquí podrás ver los aportes que tu comunidad te ha enviado.
        </p>

        <div v-if="supports.length > 0" class="space-y-4">
            <div
                v-for="support in supports.slice().reverse()"
                :key="support.id"
                class="rounded-lg border border-gray-100 bg-gray-50 p-5 shadow-sm transition hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-pink-100 text-pink-600 shadow-sm">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-800">{{ support.supporter_name }}</span>
                    </div>
                    
                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700 border border-green-200 shadow-sm">
                        {{ formatCurrency(support.amount) }}
                    </span>
                </div>
                
                <div v-if="support.message" class="mt-3 rounded bg-white p-3 text-sm text-gray-700 border border-gray-100 italic shadow-inner">
                    "{{ support.message }}"
                </div>
                
                <p class="mt-3 text-xs font-medium text-gray-400 text-right">
                    Recibido el {{ formatDate(support.created_at) }}
                </p>
            </div>
        </div>

        <div v-else class="flex flex-col items-center justify-center rounded-lg border border-dashed border-gray-200 bg-gray-50 py-12 px-4 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="text-sm font-medium text-gray-900">Sin apoyos todavía</h3>
            <p class="mt-1 text-sm text-gray-500">Comparte tu página pública para empezar a recibir impulsos.</p>
        </div>
    </div>
</template>
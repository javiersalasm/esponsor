<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// 1. Recibimos SOLO los links, no todo el perfil completo
const props = defineProps({
    links: {
        type: Array,
        default: () => []
    }
});

// Variable para saber si estamos editando un link existente (guarda el ID)
const editingLinkId = ref(null);

// 2. Estado local del formulario (aislado de las otras pestañas)
const linkForm = useForm({
    title: '',
    url: '',
});

// Función mágica para limpiar la URL antes de enviar
function formatUrl() {
    let url = linkForm.url.trim();
    if (url && !/^https?:\/\//i.test(url)) {
        linkForm.url = 'https://' + url;
    }
}

// 3. Métodos para comunicarse con tu impecable backend
function submitLink() {
    // 1. Auto-completamos el https:// antes de que valide Vue/Laravel
    formatUrl();

    // 2. Decidimos si actualizamos o creamos
    if (editingLinkId.value) {
        linkForm.put(route('links.update', editingLinkId.value), {
            preserveScroll: true,
            onSuccess: () => cancelEdit(),
        });
    } else {
        linkForm.post(route('links.store'), {
            preserveScroll: true,
            onSuccess: () => linkForm.reset(),
        });
    }
}

// Función para cargar los datos en el formulario al darle a "Editar"
function editLink(link) {
    editingLinkId.value = link.id;
    linkForm.title = link.title;
    linkForm.url = link.url;
}

// Función para cancelar la edición
function cancelEdit() {
    editingLinkId.value = null;
    linkForm.reset();
    linkForm.clearErrors();
}

function deleteLink(linkId) {
    if (confirm('¿Estás seguro de que deseas eliminar este link?')) {
        router.delete(route('links.destroy', linkId), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <div class="rounded-xl bg-white p-6 shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Mis links</h3>
        <p class="text-sm text-gray-500 mb-4">
            Agrega enlaces a tus redes sociales, portafolio u otros sitios que quieras compartir.
        </p>

        <form @submit.prevent="submitLink" class="mb-6 flex flex-col sm:flex-row gap-3 items-start">
            <div class="flex-1 w-full">
                <TextInput
                    type="text"
                    class="w-full"
                    v-model="linkForm.title"
                    placeholder="Título (ej: Mi Instagram)"
                />
                <InputError class="mt-1" :message="linkForm.errors.title" />
            </div>
            <div class="flex-1 w-full">
                <TextInput
                    type="text" 
                    class="w-full"
                    v-model="linkForm.url"
                    placeholder="www.instagram.com/miusuario"
                    @blur="formatUrl" 
                />
                <InputError class="mt-1" :message="linkForm.errors.url" />
            </div>
            
            <div class="flex gap-2 shrink-0">
                <PrimaryButton :disabled="linkForm.processing">
                    {{ editingLinkId ? 'Actualizar' : 'Agregar' }}
                </PrimaryButton>
                
                <SecondaryButton v-if="editingLinkId" @click="cancelEdit" type="button">
                    Cancelar
                </SecondaryButton>
            </div>
        </form>

        <div v-if="links.length > 0" class="space-y-2">
            <div
                v-for="link in links"
                :key="link.id"
                class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50 transition"
                :class="{'border-emerald-300 bg-emerald-50' : editingLinkId === link.id}"
            >
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-800 truncate">{{ link.title }}</p>
                    <a :href="link.url" target="_blank" class="text-sm text-indigo-600 hover:underline truncate block">
                        {{ link.url }}
                    </a>
                </div>
                
                <div class="flex items-center gap-1 ml-3">
                    <button
                        @click="editLink(link)"
                        class="text-gray-400 hover:text-emerald-600 transition p-2 rounded-md hover:bg-emerald-50"
                        title="Editar"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    
                    <button
                        @click="deleteLink(link.id)"
                        class="text-red-400 hover:text-red-600 transition p-2 rounded-md hover:bg-red-50"
                        title="Eliminar"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <p v-else class="text-center text-sm text-gray-400 py-8 bg-gray-50 rounded-lg border border-dashed border-gray-200">
            Aún no tienes links. ¡Agrega el primero!
        </p>
    </div>
</template>
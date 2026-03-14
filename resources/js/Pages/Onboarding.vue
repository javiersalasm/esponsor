<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    profile: Object,
});

const step = ref(1);
const totalSteps = 3;

const form = useForm({
    public_name: props.profile?.public_name || '',
    slug: props.profile?.slug || '',
    bio: props.profile?.bio || '',
    avatar: null,
});

const avatarPreview = ref(null);

// Auto-generar slug desde public_name
function slugify(text) {
    return text
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '');
}

watch(() => form.public_name, (val) => {
    if (step.value === 1) {
        form.slug = slugify(val);
    }
});

function nextStep() {
    if (step.value < totalSteps) {
        step.value++;
    }
}

function prevStep() {
    if (step.value > 1) {
        step.value--;
    }
}

function onAvatarChange(e) {
    const file = e.target.files[0];
    if (file) {
        form.avatar = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
}

function submit() {
    form.post(route('onboarding.update'), {
        forceFormData: true,
        onError: (errors) => {
            // Si el error está en el nombre o el slug, lo devolvemos al Paso 1
            if (errors.public_name || errors.slug) {
                step.value = 1;
            } 
            // Si el error está en la bio, lo devolvemos al Paso 2
            else if (errors.bio) {
                step.value = 2;
            }
            // Si el error es la imagen, se queda en el Paso 3
        }
    });
}
</script>

<template>
    <GuestLayout>
        <Head title="Completa tu perfil" />

        <div class="mb-6">
            <!-- Indicador de progreso -->
            <div class="flex items-center justify-center space-x-2 mb-4">
                <div
                    v-for="s in totalSteps"
                    :key="s"
                    class="h-2 w-16 rounded-full transition-colors duration-300"
                    :class="s <= step ? 'bg-gray-800' : 'bg-gray-300'"
                />
            </div>
            <p class="text-center text-sm text-gray-500">
                Paso {{ step }} de {{ totalSteps }}
            </p>
        </div>

        <form @submit.prevent="submit">
            <!-- PASO 1: Nombre público y slug -->
            <div v-show="step === 1">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">
                    ¿Cómo quieres que te conozcan?
                </h2>
                <p class="text-sm text-gray-500 mb-4">
                    Elige tu nombre público y tu nombre de cuenta único.
                </p>

                <div>
                    <InputLabel for="public_name" value="Nombre público" />
                    <TextInput
                        id="public_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.public_name"
                        placeholder="Ej: Juan Pérez"
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.public_name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="slug" value="Nombre de cuenta" />
                    <div class="mt-1 flex items-center">
                        <span class="text-sm text-gray-500 mr-1">@</span>
                        <TextInput
                            id="slug"
                            type="text"
                            class="block w-full"
                            v-model="form.slug"
                            placeholder="juan-perez"
                        />
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Tu página será: soportify.com/@{{ form.slug || '...' }}
                    </p>
                    <InputError class="mt-2" :message="form.errors.slug" />
                </div>
            </div>

            <!-- PASO 2: Biografía -->
            <div v-show="step === 2">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">
                    Cuéntanos sobre ti
                </h2>
                <p class="text-sm text-gray-500 mb-4">
                    Una breve descripción que verán quienes visiten tu perfil.
                </p>

                <div>
                    <InputLabel for="bio" value="Biografía" />
                    <textarea
                        id="bio"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        v-model="form.bio"
                        rows="4"
                        maxlength="500"
                        placeholder="Ej: Creador de contenido, desarrollador web y amante del café ☕"
                    />
                    <p class="mt-1 text-xs text-gray-400 text-right">
                        {{ form.bio.length }}/500
                    </p>
                    <InputError class="mt-2" :message="form.errors.bio" />
                </div>
            </div>

            <!-- PASO 3: Avatar -->
            <div v-show="step === 3">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">
                    Sube tu foto de perfil
                </h2>
                <p class="text-sm text-gray-500 mb-4">
                    Una imagen que te represente. Puedes cambiarla después.
                </p>

                <div class="flex flex-col items-center">
                    <div
                        class="mb-4 h-32 w-32 overflow-hidden rounded-full bg-gray-200 flex items-center justify-center"
                    >
                        <img
                            v-if="avatarPreview"
                            :src="avatarPreview"
                            class="h-full w-full object-cover"
                        />
                        <svg
                            v-else
                            class="h-16 w-16 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>

                    <label
                        class="cursor-pointer rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Elegir imagen
                        <input
                            type="file"
                            class="hidden"
                            accept="image/*"
                            @change="onAvatarChange"
                        />
                    </label>
                    <InputError class="mt-2" :message="form.errors.avatar" />
                </div>
            </div>

            <!-- Botones de navegación -->
            <div class="mt-6 flex items-center" :class="step > 1 ? 'justify-between' : 'justify-end'">
                <button
                    v-if="step > 1"
                    type="button"
                    @click="prevStep"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900"
                >
                    Atrás
                </button>

                <button
                    v-if="step < totalSteps"
                    type="button"
                    @click="nextStep"
                    class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700"
                >
                    Siguiente
                </button>

                <PrimaryButton
                    v-if="step === totalSteps"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Finalizar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
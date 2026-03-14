<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

// Perfil desde Dashboard
const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

// Inicialización formulario
const profileForm = useForm({
    public_name: props.profile?.public_name || "",
    slug: props.profile?.slug || "",
    bio: props.profile?.bio || "",
    goal_title: props.profile?.goal_title || "",
    goal_amount: props.profile?.goal_amount || "",
    avatar: null,
});

// Previsualización del avatar
const avatarPreview = ref(
    props.profile?.avatar_url ? "/storage/" + props.profile.avatar_url : null,
);

function onAvatarChange(e) {
    const file = e.target.files[0];
    if (file) {
        profileForm.avatar = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
}

// Envío de datos al backend
function submitProfile() {
    profileForm.post(route("profile.update"), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>

<template>
    <div class="rounded-xl bg-white p-6 shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Editar perfil</h3>

        <form @submit.prevent="submitProfile" class="space-y-4">
            <div>
                <InputLabel for="public_name" value="Nombre público" />
                <TextInput
                    id="public_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="profileForm.public_name"
                />
                <InputError
                    class="mt-1"
                    :message="profileForm.errors.public_name"
                />
            </div>

            <div>
                <InputLabel for="slug" value="Nombre de cuenta" />
                <div class="mt-1 flex items-center">
                    <span class="text-sm text-gray-500 mr-1">@</span>
                    <TextInput
                        id="slug"
                        type="text"
                        class="block w-full"
                        v-model="profileForm.slug"
                    />
                </div>
                <InputError class="mt-1" :message="profileForm.errors.slug" />
            </div>

            <div>
                <InputLabel for="bio" value="Biografía" />
                <textarea
                    id="bio"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="profileForm.bio"
                    rows="3"
                    maxlength="500"
                ></textarea>
                <p class="mt-1 text-xs text-gray-400 text-right">
                    {{ (profileForm.bio || "").length }}/500
                </p>
                <InputError class="mt-1" :message="profileForm.errors.bio" />
            </div>

            <div class="mt-6 border-t border-gray-100 pt-6">
                <h4 class="text-md font-medium text-gray-800 mb-4">
                    Meta actual (Opcional)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <InputLabel
                            for="goal_title"
                            value="Título de la meta"
                        />
                        <TextInput
                            id="goal_title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="profileForm.goal_title"
                            placeholder="Ej: Para comprar una cámara"
                        />
                        <InputError
                            class="mt-2"
                            :message="profileForm.errors.goal_title"
                        />
                    </div>
                    <div>
                        <InputLabel
                            for="goal_amount"
                            value="Monto objetivo ($)"
                        />
                        <TextInput
                            id="goal_amount"
                            type="number"
                            min="1"
                            max="1000"
                            class="mt-1 block w-full"
                            v-model="profileForm.goal_amount"
                            placeholder="Ej: 500"
                        />
                        <p class="mt-1 text-xs text-gray-500">El máximo por meta es de $1000.</p>
                        <InputError
                            class="mt-2"
                            :message="profileForm.errors.goal_amount"
                        />
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Deja estos campos en blanco si no quieres mostrar una meta
                    en tu página.
                </p>
            </div>

            <div>
                <InputLabel value="Foto de perfil" />
                <div class="mt-1 flex items-center gap-4">
                    <div
                        class="h-16 w-16 overflow-hidden rounded-full bg-gray-200"
                    >
                        <img
                            v-if="avatarPreview"
                            :src="avatarPreview"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <label
                        class="cursor-pointer rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        Cambiar imagen
                        <input
                            type="file"
                            class="hidden"
                            accept="image/*"
                            @change="onAvatarChange"
                        />
                    </label>
                </div>
                <InputError class="mt-1" :message="profileForm.errors.avatar" />
            </div>

            <div class="flex items-center gap-3">
                <PrimaryButton :disabled="profileForm.processing">
                    Guardar cambios
                </PrimaryButton>
                <span
                    v-if="profileForm.recentlySuccessful"
                    class="text-sm text-green-600"
                >
                    Guardado.
                </span>
            </div>
        </form>
    </div>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

import EditProfileSection from "./Sections/EditProfileSection.vue";
import ManageLinksSection from "./Sections/ManageLinksSection.vue";
import SupportsListSection from "./Sections/SupportsListSection.vue";

// Se recibe el perfil desde backend
const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

// Pestaña abierta
const activeTab = ref("profile");

// Construimos la URL pública dinámicamente
const publicUrl = computed(() => {
    // window.location.origin te da 'http://localhost:8000' o 'https://tusitio.com'
    const baseUrl = typeof window !== "undefined" ? window.location.origin : "";
    return `${baseUrl}/@${props.profile?.slug}`;
});

const copied = ref(false);

const copyToClipboard = async () => {
    try {
        await navigator.clipboard.writeText(publicUrl.value);
        copied.value = true;
        // Restaurar el botón después de 2 segundos
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch (err) {
        console.error("Error al copiar: ", err);
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/3">
                        <div class="overflow-hidden rounded-xl bg-white shadow">
                            <div
                                class="bg-gradient-to-r from-gray-800 to-gray-600 h-24"
                            ></div>
                            <div class="px-6 pb-6 -mt-12 text-center">
                                <div
                                    class="mx-auto h-24 w-24 overflow-hidden rounded-full border-4 border-white bg-gray-200 shadow"
                                >
                                    <img
                                        v-if="profile?.avatar_url"
                                        :src="'/storage/' + profile.avatar_url"
                                        class="h-full w-full object-cover"
                                        alt="Avatar"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full w-full items-center justify-center"
                                    >
                                        <svg
                                            class="h-12 w-12 text-gray-400"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"
                                            />
                                        </svg>
                                    </div>
                                </div>

                                <h2
                                    class="mt-3 text-xl font-bold text-gray-800"
                                >
                                    {{ profile?.public_name || "Sin nombre" }}
                                </h2>
                                <p class="text-sm text-gray-500">
                                    @{{ profile?.slug || "..." }}
                                </p>
                                <p
                                    v-if="profile?.bio"
                                    class="mt-2 text-sm text-gray-600"
                                >
                                    {{ profile.bio }}
                                </p>

                                <div v-if="profile?.slug" class="mt-5 border-t border-gray-100 pt-5">
                                    
                                    <a
                                        :href="'/@' + profile.slug"
                                        target="_blank"
                                        class="mb-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Ver página pública
                                    </a>

                                    <div class="flex items-center mt-2">
                                        <input 
                                            type="text" 
                                            :value="publicUrl" 
                                            readonly
                                            class="block w-full rounded-l-md border-gray-300 bg-gray-50 text-xs text-gray-500 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        />
                                        <button
                                            @click="copyToClipboard"
                                            type="button"
                                            :class="copied ? 'bg-emerald-500 border-emerald-500 text-white' : 'bg-gray-100 border-gray-300 text-gray-600 hover:bg-gray-200'"
                                            class="inline-flex items-center rounded-r-md border border-l-0 px-3 py-2 text-xs font-medium shadow-sm transition-colors duration-200"
                                            :title="copied ? '¡Copiado!' : 'Copiar enlace'"
                                        >
                                            <svg v-if="copied" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-2/3">
                        <div
                            class="mb-6 flex space-x-1 rounded-lg bg-gray-200 p-1"
                        >
                            <button
                                @click="activeTab = 'profile'"
                                :class="
                                    activeTab === 'profile'
                                        ? 'bg-white shadow text-gray-800'
                                        : 'text-gray-500 hover:text-gray-700'
                                "
                                class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition"
                            >
                                Perfil
                            </button>
                            <button
                                @click="activeTab = 'links'"
                                :class="
                                    activeTab === 'links'
                                        ? 'bg-white shadow text-gray-800'
                                        : 'text-gray-500 hover:text-gray-700'
                                "
                                class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition"
                            >
                                Links
                            </button>
                            <button
                                @click="activeTab = 'supports'"
                                :class="
                                    activeTab === 'supports'
                                        ? 'bg-white shadow text-gray-800'
                                        : 'text-gray-500 hover:text-gray-700'
                                "
                                class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition"
                            >
                                Apoyos
                            </button>
                        </div>

                        <EditProfileSection
                            v-show="activeTab === 'profile'"
                            :profile="profile"
                        />

                        <ManageLinksSection
                            v-show="activeTab === 'links'"
                            :links="profile?.links || []"
                        />

                        <SupportsListSection
                            v-show="activeTab === 'supports'"
                            :supports="profile?.supports || []"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

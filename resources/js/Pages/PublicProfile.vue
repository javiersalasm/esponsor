<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import SoportifyLogo from '@/Components/SoportifyLogo.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    profile: Object,
    is_owner: Boolean,
});

const page = usePage();
const showModal = ref(false);
const successMessage = computed(() => page.props.flash?.success);

const form = useForm({
    supporter_name: '',
    message: '',
    amount: 5,
});

function submitSupport() {
    form.post(route('creator.support', props.profile.slug), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showModal.value = false;
        },
    });
}

const avatarUrl = computed(() =>
    props.profile.avatar_url ? '/storage/' + props.profile.avatar_url : null
);

const goalProgress = computed(() => {
    if (!props.profile.goal_amount) return 0;
    
    // Laravel calcula la suma en supports_sum_amount
    const raised = props.profile.supports_sum_amount || 0; 
    const percentage = (raised / props.profile.goal_amount) * 100;
    
    // Si superan la meta, lo topamos al 100% para que la barra no se desborde visualmente
    return percentage > 100 ? 100 : Math.round(percentage);
});
</script>

<template>
    <Head :title="profile.public_name" />

    <div class="min-h-screen bg-gray-100">
        <div class="absolute top-6 left-6 z-10">
            <Link 
                :href="route('welcome')" 
                class="flex items-center gap-2 rounded-full bg-black/20 px-4 py-2 text-sm font-medium text-white/90 backdrop-blur-sm transition-all hover:bg-black/40 hover:text-white hover:scale-105 shadow-sm"
            >
                <SoportifyLogo width="20" height="20" />
                <span>Soportify</span>
            </Link>
        </div>
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-600 h-48"></div>

        <div class="mx-auto max-w-2xl px-4 -mt-20 pb-12">
            <!-- Tarjeta de perfil -->
            <div class="rounded-xl bg-white p-6 shadow text-center">
                <!-- Avatar -->
                <div class="mx-auto -mt-16 mb-4 h-28 w-28 overflow-hidden rounded-full border-4 border-white bg-gray-200 shadow">
                    <img
                        v-if="avatarUrl"
                        :src="avatarUrl"
                        class="h-full w-full object-cover"
                    />
                    <div v-else class="flex h-full w-full items-center justify-center">
                        <svg class="h-14 w-14 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-2xl font-bold text-gray-800">{{ profile.public_name }}</h1>
                <p class="text-sm text-gray-500">@{{ profile.slug }}</p>
                <p v-if="profile.bio" class="mt-3 text-gray-600">{{ profile.bio }}</p>

                <div v-if="profile.goal_title && profile.goal_amount" class="mt-6 text-left bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">META ACTUAL</p>
                            <p class="text-sm font-medium text-gray-800">{{ profile.goal_title }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-gray-900">${{ profile.supports_sum_amount || 0 }}</span>
                            <span class="text-xs text-gray-500"> de ${{ profile.goal_amount }}</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div 
                            class="bg-emerald-500 h-2.5 rounded-full transition-all duration-1000 ease-out" 
                            :style="{ width: goalProgress + '%' }"
                        ></div>
                    </div>
                    <p class="text-xs text-gray-500 text-right mt-1">{{ goalProgress }}% completado</p>
                </div>

                <!-- Botón apoyar -->
                <button
                    v-if="!is_owner" 
                    @click="showModal = true"
                    class="mt-5 inline-flex items-center gap-2 rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition"
                >
                
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Apoyar al creador
                </button>
                <p v-else class="mt-5 text-sm text-gray-500 italic">Esta es tu vista pública. Así es como la ven tus seguidores.</p>
            </div>

            <!-- Mensaje de éxito -->
            <div
                v-if="successMessage"
                class="mt-4 rounded-lg bg-green-50 border border-green-200 p-4 text-center text-sm text-green-700"
            >
                {{ successMessage }}
            </div>

            <!-- Links -->
            <div v-if="profile.links?.length" class="mt-8">
                <h3 class="text-center text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4 text-left">
                    Listado de links
                </h3>
                <div class="space-y-3">
                    <a
                        v-for="link in profile.links.slice().reverse()"
                        :key="link.id"
                        :href="link.url"
                        target="_blank"
                        class="block rounded-lg border border-gray-200 bg-white px-5 py-4 text-center font-medium text-gray-800 shadow-sm hover:bg-gray-50 hover:shadow hover:border-emerald-300 transition-all duration-200"
                    >
                        {{ link.title }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ MODAL: Apoyar al creador ═══ -->
    <Teleport to="body">
        <div
            v-if="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center"
        >
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50" @click="showModal = false"></div>

            <!-- Modal -->
            <div class="relative z-10 w-full max-w-md rounded-xl bg-white p-6 shadow-xl mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Apoyar a {{ profile.public_name }}
                    </h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitSupport" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tu nombre</label>
                        <input
                            type="text"
                            v-model="form.supporter_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="¿Cómo te llamas?"
                        />
                        <p v-if="form.errors.supporter_name" class="mt-1 text-sm text-red-600">{{ form.errors.supporter_name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mensaje</label>
                        <textarea
                            v-model="form.message"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Escribe un mensaje de apoyo..."
                        />
                        <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Monto ($)</label>
                        <div class="mt-1 flex gap-2">
                            <button
                                v-for="val in [1, 5, 10, 15, 20]"
                                :key="val"
                                type="button"
                                @click="form.amount = val"
                                :class="form.amount === val ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="rounded-lg px-3 py-1.5 text-sm font-medium transition"
                            >
                                ${{ val }}
                            </button>
                        </div>
                        <input
                            type="number"
                            v-model.number="form.amount"
                            min="1"
                            max="100"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ingrese su monto a aportar"
                        />
                        <p v-if="form.errors.amount" class="mt-1 text-sm text-red-600">{{ form.errors.amount }}</p>
                        <span class="flextext-sm text-gray-500">Nota: Como máximo $100 por donación.</span>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition disabled:opacity-50"
                    >
                        <span v-if="form.processing">Enviando...</span>
                        <span v-else>Enviar apoyo de ${{ form.amount }}</span>
                    </button>
                </form>
            </div>
        </div>
    </Teleport>
</template>
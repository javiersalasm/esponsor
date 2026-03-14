<script setup>
import { Head, Link } from "@inertiajs/vue3";
import {
    UserCircleIcon,
    LinkIcon,
    HeartIcon,
    SparklesIcon,
    ChatBubbleLeftRightIcon,
    ChartBarIcon,
    DevicePhoneMobileIcon,
    BoltIcon,
} from "@heroicons/vue/24/outline";
import SoportifyLogo from "@/Components/SoportifyLogo.vue";

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
});

const steps = [
    {
        number: 1,
        icon: UserCircleIcon,
        title: "Crea tu cuenta",
        description:
            "Regístrate gratis y configura tu perfil con tu nombre, bio y avatar.",
    },
    {
        number: 2,
        icon: LinkIcon,
        title: "Comparte tu link",
        description:
            "Obtén tu URL única tipo soportify.com/tunombre y compártela.",
    },
    {
        number: 3,
        icon: HeartIcon,
        title: "Recibe apoyos",
        description:
            "Tu comunidad puede enviarte un apoyo simbólico con un mensaje.",
    },
];

const features = [
    {
        icon: SparklesIcon,
        title: "Página personalizada",
        description:
            "Avatar, nombre público, bio y links a tus redes sociales.",
    },
    {
        icon: LinkIcon,
        title: "Tu propio link",
        description: "URL única para compartir en todas tus redes.",
    },
    {
        icon: ChatBubbleLeftRightIcon,
        title: "Mensajes de apoyo",
        description:
            "Tus seguidores pueden enviarte un mensaje junto a su apoyo.",
    },
    {
        icon: ChartBarIcon,
        title: "Panel de control",
        description: "Ve todos tus apoyos recibidos con fecha, nombre y monto.",
    },
    {
        icon: DevicePhoneMobileIcon,
        title: "100% Responsivo",
        description: "Funciona perfecto en celular, tablet y computador.",
    },
    {
        icon: BoltIcon,
        title: "Rápido y simple",
        description: "Sin pagos reales, sin configuraciones complicadas.",
    },
];
</script>

<template>
    <Head title="Soportify — Apoyo directo. Creatividad sin límites." />

    <div class="min-h-screen bg-white text-gray-900">
        <!-- NAVBAR -->
        <header
            class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100"
        >
            <div
                class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex h-16 items-center justify-between"
            >
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <SoportifyLogo width="32" height="32" />
                    <span class="text-xl font-bold text-gray-900"
                        >Soportify</span
                    >
                </div>

                <!-- Nav links -->
                <nav v-if="canLogin" class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 transition"
                    >
                        Mi panel
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 transition"
                        >
                            Iniciar sesión
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-lg px-4 py-2 text-sm font-semibold text-white transition"
                            style="
                                background: linear-gradient(
                                    135deg,
                                    #00c9a7,
                                    #00e676
                                );
                            "
                        >
                            Crear mi página
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- HERO -->
        <section class="relative overflow-hidden py-20 sm:py-32">
            <div class="absolute inset-0 -z-10">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[500px] rounded-full opacity-10 blur-3xl"
                    style="
                        background: radial-gradient(circle, #00c9a7, #00e676);
                    "
                ></div>
            </div>

            <div class="mx-auto max-w-4xl px-4 sm:px-6 text-center">
                <span
                    class="inline-block mb-4 rounded-full px-4 py-1 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200"
                >
                    ✨ La plataforma de apoyo para creadores
                </span>
                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight"
                >
                    Crea, comparte y recibe.<br />
                    <span
                        style="
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-image: linear-gradient(
                                135deg,
                                #00c9a7,
                                #00b894
                            );
                        "
                    >
                        Así de simple.
                    </span>
                </h1>
                <p
                    class="mt-6 text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto"
                >
                    Crea tu página de creador en minutos, comparte tu link y
                    recibe apoyos simbólicos de tu comunidad. Gratis, simple y
                    directo.
                </p>
                <div
                    class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4"
                >
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="w-full sm:w-auto rounded-xl px-8 py-4 text-base font-semibold text-white shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5"
                        style="
                            background: linear-gradient(
                                135deg,
                                #00c9a7,
                                #00e676
                            );
                        "
                    >
                        Crear mi página gratis →
                    </Link>
                    <a
                        href="#como-funciona"
                        class="w-full sm:w-auto rounded-xl px-8 py-4 text-base font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition"
                    >
                        Ver cómo funciona
                    </a>
                </div>

                <!-- Social proof -->
                <p class="mt-8 text-sm text-gray-400">
                    Recibe tu apoyo · Listo en 2 minutos
                </p>
            </div>
        </section>

        <!-- PREVIEW CARD -->
        <section class="pb-20 px-4">
            <div
                class="mx-auto max-w-sm sm:max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
            >
                <!-- Fake profile card -->
                <div
                    class="h-24 w-full"
                    style="
                        background: linear-gradient(135deg, #00c9a7, #00e676);
                    "
                ></div>
                <div class="px-6 pb-6 -mt-10">
                    <div
                        class="w-20 h-20 rounded-full border-4 border-white bg-gray-200 overflow-hidden mb-3"
                    >
                        <div
                            class="w-full h-full flex items-center justify-center text-3xl"
                        >
                            🎨
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Javier Ignacio
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Apasionado por el software y la música.
                    </p>
                    <div class="mt-4 space-y-2">
                        <div
                            class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:border-emerald-400 transition"
                        >
                            🎬 Mi canal de YouTube
                        </div>
                        <div
                            class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:border-emerald-400 transition"
                        >
                            📸 Instagram
                        </div>
                    </div>
                    <div
                        class="mt-4 w-full rounded-xl py-3 text-sm font-semibold text-white transition text-center"
                        style="
                            background: linear-gradient(
                                135deg,
                                #00c9a7,
                                #00e676
                            );
                        "
                    >
                        💵 Apoyar a Javier
                </div>
                </div>
            </div>
        </section>

        <!-- CÓMO FUNCIONA -->
        <section id="como-funciona" class="py-20 bg-gray-50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2
                        class="text-3xl sm:text-4xl font-extrabold text-gray-900"
                    >
                        ¿Cómo funciona?
                    </h2>
                    <p class="mt-3 text-gray-500 text-lg">
                        Tres pasos y ya estás listo para recibir apoyos.
                    </p>
                </div>
                <div class="grid gap-8 sm:grid-cols-3">
                    <div
                        v-for="step in steps"
                        :key="step.number"
                        class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center hover:shadow-md transition hover:border-emerald-200"
                    >
                        <component
                            :is="step.icon"
                            class="w-10 h-10 text-emerald-500 mx-auto mb-4"
                        />
                        <div
                            class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2"
                        >
                            Paso {{ step.number }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            {{ step.title }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ step.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section class="py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2
                        class="text-3xl sm:text-4xl font-extrabold text-gray-900"
                    >
                        Todo lo que necesitas
                    </h2>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="rounded-2xl p-6 border border-gray-100 hover:border-emerald-200 hover:shadow-md transition"
                    >
                        <component
                            :is="feature.icon"
                            class="w-8 h-8 text-emerald-500 mb-3"
                        />
                        <h3 class="text-base font-bold text-gray-900 mb-1">
                            {{ feature.title }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section
            class="py-20"
            style="background: linear-gradient(135deg, #00c9a7, #00b894)"
        >
            <div class="mx-auto max-w-3xl px-4 text-center">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">
                    ¿Listo para empezar?
                </h2>
                <p class="mt-4 text-lg text-white/80">
                    Crea tu página gratuita hoy y comparte tu link con tu
                    comunidad.
                </p>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="mt-8 inline-block rounded-xl px-10 py-4 text-base font-bold text-emerald-700 bg-white hover:bg-gray-50 shadow-lg transition"
                >
                    Crear mi página gratis →
                </Link>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="py-8 border-t border-gray-100">
            <div
                class="mx-auto max-w-7xl px-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-400"
            >
                <div class="flex items-center gap-2">
                    <SoportifyLogo width="20" height="20" />
                    <span class="font-semibold text-gray-600">Soportify</span>
                </div>
                <p>APOYO DIRECTO. CREATIVIDAD SIN LÍMITES.</p>
            </div>
        </footer>
    </div>
</template>

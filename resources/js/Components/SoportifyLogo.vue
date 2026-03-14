<script setup>
defineProps({
    width: { type: String, default: "32" },
    height: { type: String, default: "32" }
});
</script>

<template>
    <svg
        :width="width"
        :height="height"
        viewBox="0 0 100 100"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <defs>
            <linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color: #00c9a7" />
                <stop offset="100%" style="stop-color: #00e676" />
            </linearGradient>
        </defs>
        <path d="M30 20 C10 20 10 50 30 50 C50 50 50 80 30 80" stroke="url(#logoGrad)" stroke-width="14" stroke-linecap="round" fill="none" />
        <path d="M70 20 C50 20 50 50 70 50 C90 50 90 80 70 80" stroke="url(#logoGrad)" stroke-width="14" stroke-linecap="round" fill="none" />
    </svg>
</template>
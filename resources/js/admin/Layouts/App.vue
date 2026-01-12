<template>
    <Sidebar />
    <Navbar />
    <section class="home-section relative top-16">
        <main class="flex-1 max-h-full p-3 bg-gray-200 py-4">
            <slot />
        </main>
    </section>
</template>

<script>
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
export default {
    components: {
        Sidebar,
        Navbar,
    },
};
</script>

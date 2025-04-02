<script setup>
import { onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
onMounted(() => {
    if (!localStorage.getItem('dashboardReloaded')) {
        localStorage.setItem('dashboardReloaded', 'true'); // Marca que ya se recargó
        window.location.reload(); // Forzar recarga del navegador
    } else {
        localStorage.removeItem('dashboardReloaded'); // Limpia la marca después de la recarga
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div v-if="is('admin')" class="p-6 text-gray-900">
                        Como administrador tienes acceso a funciones para agregar, editar, eliminar y visualizar usuarios. De igual manera puedes acceder a la sección de "Perfil".
                    </div>
                    <div v-if="is('user')" class="p-6 text-gray-900">
                        Como usuario estándar tienes acceso a la sección de "Perfil".
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { useForm } from '@inertiajs/vue3';
import UsersModal from '@/Components/UsersModal.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    users: {
        type: Object,
    },
});
const form = useForm({
});

const deleteUser = (id, name) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Quieres eliminar a ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('users.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire(
                        'Eliminado!',
                        `Usuario ${name} eliminado.`,
                        'success'
                    );
                },
            });
        }
    });
};

const changeRoleUser = (id, name) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Quieres cambiar el rol de ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.put(route('users.change', id), {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire(
                        'Rol modificado!',
                        `El rol de ${name} cambió.`,
                        'success'
                    );
                },
            });
        }
    });
};

const openModal = (user) => {
    document.getElementById('id2').value = user.id;
    document.getElementById('name2').value = user.name;
    document.getElementById('email2').value = user.email;
    document.getElementById('phone2').value = user.phone;
};
</script>

<template>
    <Head title="Users Managment" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Users Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    
                    <div class="container-fluid mt-3 bg-white">
                        <div class="row mt-3 mx-10 justify-content-between">

                            <div class="col-4 text-start">
                                <div class="">
                                    <button 
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalCreate"
                                    >
                                        <i class="fa-solid fa-plus"></i> Añadir Usuario
                                    </button>
                                </div>
                            </div>

                            <div class="col-4 text-end">
                                <div class="">
                                    <a 
                                        class="btn btn-secondary"
                                        href="/users-export"
                                    >
                                        <i class="fa-solid fa-file-export"></i> Exportar Usuarios
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">

                            <div class="col-md-10 offset-md-1">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Teléfono</th>
                                                <th scope="col">Rol</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user, i in users.data" :key="user.id">
                                                <td>{{ i + 1 }}</td>
                                                <td>{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ user.phone }}</td>
                                                <td>
                                                    <span v-for="role in user.roles" :key="role.id">
                                                        {{ role.name }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <!-- Cambiar Role -->
                                                    <button 
                                                        class="btn btn-danger me-2"
                                                        @click="changeRoleUser(user.id, user.name)"
                                                        title="Cambiar Rol"
                                                        >
                                                        <i class="fa-solid fa-repeat"></i>
                                                    </button>

                                                    <!-- Editar -->
                                                    <button 
                                                        class="btn btn-warning me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit"
                                                        @click="openModal(user)"
                                                        title="Modificar Usuario"
                                                    >
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>

                                                    <!-- Eliminar -->
                                                    <button 
                                                        class="btn btn-danger me-2"
                                                        @click="deleteUser(user.id, user.name)"
                                                        title="Eliminar Usuario"
                                                        >
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination class="mt-3 mb-3" :links="users.links"  />

                                </div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
            
        <UsersModal
            :modal="'modalCreate'"
            :title="'Crear Usuario'"
            :op="'1'"
        >
        </UsersModal>

        <UsersModal
            :modal="'modalEdit'"
            :title="'Modificar Usuario'"
            :op="'2'"
        >
        </UsersModal>
    </AuthenticatedLayout>
</template>

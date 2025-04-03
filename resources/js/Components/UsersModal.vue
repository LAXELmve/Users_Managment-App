<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    modal: {
        type: String,
    },
    title: {
        type: String,
    },
    op: {
        type: String,
    },
});

const cleanInput = (field, regex) => {
    form[field] = form[field].replace(regex, '');
};

const form = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: '',
    phone: props.user.phone,
});

const save = () => {
    form.post(route('users.store'), {
        onSuccess: () => close()
    });
};

const update = () => {
    /* var id = props.user.id; */
    var id = document.getElementById('id2').value;
    form.put(route('users.update', id), {
        onSuccess: () => close()
    });
};

const close = () => {
    form.reset();
    document.getElementById('cerrar' + props.op).click();
};

</script>

<template>
    <div class="modal fade" :id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ title }}
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="(op === '1') ? save() : update()">
                        <div class="mb-3">
                            <TextInput :id="'id'+op" type="hidden" name="id" v-model="form.id"></TextInput>
                        </div>
                        <div class="mb-3">
                            <InputLabel for="name" value="Nombre" />

                            <TextInput
                                :id="'name'+op"
                                type="name"
                                class="form-control mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                @input="cleanInput('name', /[^a-zA-Z0-9\s]/g)"
                            />
                            <div>
                                <small class="text-danger" v-if="form.errors.name">
                                    {{ form.errors.name }}
                                </small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                :id="'email'+op"
                                type="email"
                                class="form-control mt-1 block w-full"
                                v-model="form.email"
                                required
                                autofocus
                            />
                            <div>
                                <small class="text-danger" v-if="form.errors.email">
                                    {{ form.errors.email }}
                                </small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <InputLabel for="phone" value="Teléfono" />

                            <TextInput
                                :id="'phone'+op"
                                type="phone"
                                class="form-control mt-1 block w-full"
                                v-model="form.phone"
                                autofocus
                                @input="cleanInput('phone', /[^a-zA-Z0-9\+\-\(\)\s]/g)"
                            />
                            <div>
                                <small class="text-danger" v-if="form.errors.phone">
                                    {{ form.errors.phone }}
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <InputLabel for="password" value="Contraseña" />

                            <TextInput
                                id="password"
                                type="text"
                                class="form-control mt-1 block w-full"
                                v-model="form.password"
                                autofocus
                            />
                            <div>
                                <small class="text-danger" v-if="form.errors.password">
                                    {{ form.errors.password }}
                                </small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" :id="'cerrar'+op">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

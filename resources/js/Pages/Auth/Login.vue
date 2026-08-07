<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login" />

    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">SmartCampus Login</h4>

                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.email }"
                            required autofocus
                        />
                        <div class="invalid-feedback" v-if="form.errors.email">{{ form.errors.email }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.password }"
                            required
                        />
                        <div class="invalid-feedback" v-if="form.errors.password">{{ form.errors.password }}</div>
                    </div>

                    <div class="mb-3 form-check">
                        <input v-model="form.remember" type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">
                        <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

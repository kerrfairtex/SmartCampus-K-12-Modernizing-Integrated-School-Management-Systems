<script setup>
import { usePage } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

const page = usePage();
</script>

<template>
    <div>
        <Navbar :auth="page.props.auth" />

        <!-- Flash messages -->
        <div class="container-fluid mt-2" v-if="page.props.flash?.message">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ page.props.flash.message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <div class="container-fluid mt-2" v-if="page.props.flash?.error">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ page.props.flash.error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>

        <main>
            <slot />
        </main>
    </div>
</template>

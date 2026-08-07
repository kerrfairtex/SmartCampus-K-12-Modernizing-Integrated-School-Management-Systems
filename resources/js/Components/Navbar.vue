<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    auth: Object,
});
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <Link class="navbar-brand" :href="route('home')">
                SmartCampus
            </Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown" v-if="auth.user">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth.user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <Link class="dropdown-item" :href="route('profile.show')">Profile</Link>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <Link class="dropdown-item" :href="route('logout')" method="post" as="button">
                                    Logout
                                </Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

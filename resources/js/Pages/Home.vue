<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    totalStudents: Number,
    totalTeachers: Number,
    totalBooks: Number,
    totalClasses: Number,
    totalSections: Number,
    notices: Array,
    events: Array,
    routines: Array,
    syllabuses: Array,
    exams: Array,
});
</script>

<template>
    <AppLayout>
        <Head title="Dashboard" />

        <div class="container-fluid py-4">
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Students</h5>
                            <p class="card-text display-6">{{ totalStudents }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Teachers</h5>
                            <p class="card-text display-6">{{ totalTeachers }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Classes</h5>
                            <p class="card-text display-6">{{ totalClasses }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Books</h5>
                            <p class="card-text display-6">{{ totalBooks }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Recent Notices</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" v-for="notice in notices" :key="notice.id">
                                {{ notice.title }}
                            </li>
                            <li class="list-group-item text-muted" v-if="!notices?.length">No notices.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Upcoming Events</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" v-for="event in events" :key="event.id">
                                {{ event.title }}
                            </li>
                            <li class="list-group-item text-muted" v-if="!events?.length">No events.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

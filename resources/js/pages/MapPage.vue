<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import ActivityHeatMap from '@/components/dashboard/ActivityHeatMap.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Map',
        href: '/map', // Assuming you create a route helper for this
    },
];

// You can fetch this data from your backend or use static data
const heatmapData = [
    [9.8916, 8.8547],
    [9.8236, 8.8347],
    [9.8916, 8.8447],
    [9.8236, 8.8147],
    [9.8916, 8.8247],
    [9.8236, 8.8547],
    [9.8976, 8.8847],
    [9.8911, 8.3986],
    [9.7966, 8.3999],
];
</script>

<template>
    <Head title="Activity Map" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- The parent div will fill the layout's content area -->
        <div class="h-full w-full p-4">
            <ActivityHeatMap :heatmap-data="heatmapData" class="h-full w-full" />
        </div>
    </AppLayout>
</template>
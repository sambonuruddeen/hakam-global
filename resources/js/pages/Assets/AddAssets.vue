<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import AddAsset from '@/components/Assets/AddAsset.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Assets',
        href: '/asset',
    },
    {
        title: 'Add Asset',
        href: '/add-asset',
    },
];

</script>
<template>
    <Head title="Add Assets" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container px-6 py-10 mx-auto">
            <AddAsset />
        </div>
      
        
    </AppLayout>        

</template>
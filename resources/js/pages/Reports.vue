<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { reports } from '@/routes';

import { onMounted, ref } from 'vue';
import  DataTable  from '@/components/Enumerations/DataTable.vue';
import { columns, type Assets } from '@/components/Enumerations/columns';


const report =[
    {
        id: 1,
        name: 'Asset 1',
        detail1: 'Description for Customer 1',
        detail2: 'Good, Very Good',
    },
];


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Reports',
        href: '/reports',
    },
];
</script>

<template>
    <Head title="reports" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- The parent div will fill the layout's content area -->
        <!-- The parent div will fill the layout's content area -->
         <div class="container px-6 py-10 mx-auto">
            <DataTable :columns="columns" :data="report" />
        </div>

    </AppLayout>        

</template>
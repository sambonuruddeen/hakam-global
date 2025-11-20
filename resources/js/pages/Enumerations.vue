<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

import { onMounted, ref } from 'vue';
import  DataTable  from '@/components/Enumerations/DataTable.vue';
import { columns, type Assets } from '@/components/Enumerations/columns';

const enumerations = [
    {
        id: 1,
        name: 'Asset 1',
        detail1: 'Description for Customer 1',
        detail2: 'Good, Very Good',
    },
    {
        id: 2,
        name: 'Asset 2',
        detail1: 'Description for Customer 2',
        detail2: 'Fair, Poor',
    },
    {
        id: 3,
        name: 'Asset 3',
        detail1: 'Description for Customer 3',
        detail2: 'Excellent',
    },
];


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Enumerations',
        href: '/enumerations',
    },
];


</script>

<template>
    <Head title="Enumerations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- The parent div will fill the layout's content area -->
         <div class="container px-6 py-10 mx-auto">
            <DataTable :columns="columns" :data="enumerations" />
        </div>
        <hr class="my-4" />
        <!-- The parent div will fill the layout's content area -->
      
    </AppLayout>        

</template>
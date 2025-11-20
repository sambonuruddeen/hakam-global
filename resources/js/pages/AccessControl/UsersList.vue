<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

import  DataTable  from '@/components/AccessControl/DataTable.vue';
import { columns } from '@/components/AccessControl/columns';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '#',
    },
];

const data = [
    {
        id: 1,
        name: 'John Doe',
        email: 'john@example.com',
        role: 'Admin',
    },
    {
        id: 2,
        name: 'Jane Smith',
        email: 'jane@example.com',
        role: 'User',
    },
    {
        id: 3,
        name: 'Bob Johnson',
        email: 'bob@example.com',
        role: 'Admin',
    },
];
</script>
<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div class="container px-6 py-10 mx-auto">
            <DataTable :columns="columns" :data="data" />
        </div>
        
        
    </AppLayout>    
</template>
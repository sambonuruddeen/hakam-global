<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

import  DataTable  from '@/components/RolePermission/DataTable.vue';
import { columns } from '@/components/RolePermission/columns';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '#',
    },
];

// Roles and their permissions data
const data = [
    {
        id: 1,
        name: 'Role Admin',
        description: 'Admin role with full permissions',
        permissions: ['create user', 'edit user', 'delete user'],
    },
    {
        id: 2,
        name: 'Role Editor',
        description: 'Editor role with limited permissions',
        permissions: ['view user', 'edit user'],
    },
    {        
        id: 3,
        name: 'Role Viewer',
        description: 'Viewer role with read-only permissions',
        permissions: ['create user', 'delete user'],
    },
   
];
</script>
<template>
    <Head title="Roles and Permissions" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div class="container px-6 py-10 mx-auto">
            <DataTable :columns="columns" :data="data" />
        </div>
        
        
    </AppLayout>    
</template>
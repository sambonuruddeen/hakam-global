<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

import { onMounted, ref } from 'vue';
import  DataTable  from '@/components/Assets/DataTable.vue';
import { columns, type Assets } from '@/components/Assets/columns';

const data = ref<Assets[]>([])

async function getData(): Promise<Assets[]> {
  // Fetch data from your API here.
  return [
     {
        id: 1,
        name: 'Asset 1',
        description: 'Description for Asset 1',
        assetConditions: 'Good, Very Good',
    },
    {
        id: 2,
        name: 'Asset 2',
        description: 'Description for Asset 2',
        assetConditions: 'Fair, Poor',
    },
    {
        id: 3,
        name: 'Asset 3',
        description: 'Description for Asset 3',
        assetConditions: 'Excellent',
    },
     {
        id: 4,
        name: 'Asset 1',
        description: 'Description for Asset 1',
        assetConditions: 'Good, Very Good',
    },
    {
        id: 5,
        name: 'Asset 2',
        description: 'Description for Asset 2',
        assetConditions: 'Fair, Poor',
    },
    {
        id: 6,
        name: 'Asset 3',
        description: 'Description for Asset 3',
        assetConditions: 'Excellent',
    },
     {
        id: 7,
        name: 'Asset 1',
        description: 'Description for Asset 1',
        assetConditions: 'Good, Very Good',
    },
    {
        id: 8,
        name: 'Asset 2',
        description: 'Description for Asset 2',
        assetConditions: 'Fair, Poor',
    },
    {
        id: 9,
        name: 'Asset 3',
        description: 'Description for Asset 3',
        assetConditions: 'Excellent',
    },
     {
        id: 10,
        name: 'Asset 1',
        description: 'Description for Asset 1',
        assetConditions: 'Good, Very Good',
    },
    {
        id: 11,
        name: 'Asset 2',
        description: 'Description for Asset 2',
        assetConditions: 'Fair, Poor',
    },
    {
        id: 12,
        name: 'Asset 3',
        description: 'Description for Asset 3',
        assetConditions: 'Excellent',
    },

    
  ]
}

onMounted(async () => {
  data.value = await getData()
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Assets',
        href: '/asset',
    },
];


</script>

<template>
    <Head title="assets" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div class="container px-6 py-10 mx-auto">
            <DataTable :columns="columns" :data="data" />
        </div>
        
        
    </AppLayout>        

</template>
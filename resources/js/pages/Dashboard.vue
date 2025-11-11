<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import DailyActivityTrend from '@/components/dashboard/DailyActivityTrend.vue';
import TeamPerformance from '@/components/dashboard/TeamPerformance.vue';
import DataQualityChart from '@/components/dashboard/DataQualityChart.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const pageProps = defineProps<{
    activitiesTrend: { date: string; count: number }[];
    teamData: { name: string; today: number; total: number }[];
    qualityStats: { label: string; value: number; color: string }[];
}>();

// Define static data for the DailyActivityTrend component
const staticActivitiesTrend = [
    {
        date: '10-01-2026',
        count: 10,
    },
    {
        date: '10-02-2026',
        count: 5,
    },
    {
        date: '10-03-2026',
        count: 8,
    },
    {
        date: '10-04-2026',
        count: 3,
    },
];

// Define static data for the DataQualityChart
const staticQualityStats = [
    {
        label: 'Passed',
        value: 75,
        color: 'hsl(142.1 76.2% 36.3%)', // Green
    },
    {
        label: 'Pending',
        value: 15,
        color: 'hsl(47.9 95.8% 53.1%)', // Yellow
    },
    {
        label: 'Rejected',
        value: 10,
        color: 'hsl(0 84.2% 60.2%)', // Red
    },
];

// define static data for the TeamPerformance component
const staticTeamData = [
    {
        name: 'Feeder 1',
        today: 10,
        total: 20,
    },
    {
        name: 'Feeder 2',
        today: 5,
        total: 15,
    },
    {
        name: 'Feeder 3',
        today: 8,
        total: 12,
    },
    {
        name: 'Feeder 4',
        today: 3,
        total: 16,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <div class="grid auto-rows-min gap-4 lg:grid-cols-3">
                <DailyActivityTrend
                    :activities-trend="pageProps.activitiesTrend"
                    class="lg:col-span-2"
                />
                <DataQualityChart :quality-stats="staticQualityStats" />
            </div>
            <div class="grid grid-cols-1">
                <!-- <TeamPerformance :team-data="pageProps.teamData" /> -->
                <TeamPerformance :team-data="staticTeamData" />
            </div>
        </div>
    </AppLayout>
</template>

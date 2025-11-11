<script setup lang="ts">
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    type ChartOptions,
    type ChartData,
} from 'chart.js';
import { computed } from 'vue';
import { Line } from 'vue-chartjs';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
);

interface ActivityTrend {
    date: string;
    count: number;
}

const props = defineProps<{
    activitiesTrend: ActivityTrend[];
}>();

const chartData = computed<ChartData<'line'>>(() => ({
    labels: props.activitiesTrend.map((item) => item.date),
    datasets: [
        {
            label: 'Activities',
            backgroundColor: 'hsl(var(--primary))',
            borderColor: 'hsl(var(--primary))',
            data: props.activitiesTrend.map((item) => item.count),
            tension: 0.3,
        },
    ],
}));

const chartOptions: ChartOptions<'line'> = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
        },
    },
    scales: {
        y: {
            beginAtZero: true,
        },
    },
};
</script>

<template>
    <div
        class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
    >
        <h3 class="mb-2 text-lg font-semibold">Daily Activity Trend</h3>
        <div class="relative h-[calc(100%-2rem)]">
            <Line
                v-if="activitiesTrend?.length"
                :data="chartData"
                :options="chartOptions"
            />
        </div>
    </div>
</template>

<!-- 
Daily Activity Trend (Line Chart):

Component Name: DailyActivityTrend.vue
Visualization: A Line Chart showing activity counts over the last 30 days.
Data Input (Props): Expects an activities_trend prop: Array&lt;{date: string, count: number}&gt;.
Requirement: Use a common Vue charting library like Vue Chart.js or a simple charting solution.
-->
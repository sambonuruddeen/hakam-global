<script setup lang="ts">
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend,
    type ChartData,
    type ChartOptions,
} from 'chart.js';
import { computed } from 'vue';
import { Doughnut } from 'vue-chartjs';

ChartJS.register(ArcElement, Tooltip, Legend);

interface QualityStat {
    label: string;
    value: number;
    color: string;
}

const props = defineProps<{
    qualityStats: QualityStat[];
}>();

const chartData = computed<ChartData<'doughnut'>>(() => ({
    labels: props.qualityStats.map((item) => item.label),
    datasets: [
        {
            backgroundColor: props.qualityStats.map((item) => item.color),
            data: props.qualityStats.map((item) => item.value),
        },
    ],
}));

const chartOptions: ChartOptions<'doughnut'> = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
        },
    },
};
</script>

<template>
    <div
        class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
    >
        <h3 class="mb-2 text-lg font-semibold">Data Quality Status</h3>
        <div class="relative h-[calc(100%-2rem)]">
            <Doughnut
                v-if="qualityStats?.length"
                :data="chartData"
                :options="chartOptions"
            />
        </div>
    </div>
</template>

<!-- 
Data Quality Status (Donut/Pie Chart):

Component Name: DataQualityChart.vue
Visualization: A Donut or Pie Chart representing the percentage breakdown of different activity statuses (e.g., Passed, Pending, Rejected).
Data Input (Props): Expects a quality_stats prop: Array&lt;{label: string, value: number, color: string}&gt;.
-->
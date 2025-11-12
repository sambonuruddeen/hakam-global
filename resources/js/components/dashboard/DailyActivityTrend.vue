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
import { computed, watch } from 'vue';
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

// Dark mode reactive variable - you can pass this as a prop or use with a store
const isDarkMode = computed(() => {
    // You can also receive this as a prop from parent component
    return document.documentElement.classList.contains('dark');
});

// Colors that adapt to dark/light mode
const getChartColors = computed(() => {
    if (isDarkMode.value) {
        return {
            primary: 'hsl(210, 40%, 70%)', // Lighter primary for dark mode
            grid: 'rgba(255, 255, 255, 0.1)',
            text: 'rgba(255, 255, 255, 0.8)',
            background: 'transparent'
        };
    } else {
        return {
            primary: 'hsl(var(--primary))',
            grid: 'rgba(0, 0, 0, 0.1)',
            text: 'rgba(0, 0, 0, 0.8)',
            background: 'transparent'
        };
    }
});

const chartData = computed<ChartData<'line'>>(() => ({
    labels: props.activitiesTrend.map((item) => item.date),
    datasets: [
        {
            label: 'Activities',
            backgroundColor: getChartColors.value.primary,
            borderColor: getChartColors.value.primary,
            data: props.activitiesTrend.map((item) => item.count),
            tension: 0.3,
            pointBackgroundColor: getChartColors.value.primary,
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
        },
    ],
}));

const chartOptions = computed<ChartOptions<'line'>>(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
        },
        tooltip: {
            backgroundColor: isDarkMode.value ? 'rgba(30, 30, 30, 0.9)' : 'rgba(255, 255, 255, 0.9)',
            titleColor: isDarkMode.value ? 'rgba(255, 255, 255, 0.9)' : 'rgba(0, 0, 0, 0.9)',
            bodyColor: isDarkMode.value ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)',
            borderColor: isDarkMode.value ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.2)',
            borderWidth: 1,
            cornerRadius: 6,
            displayColors: false,
            callbacks: {
                label: function(context) {
                    return `Activities: ${context.parsed.y}`;
                }
            }
        },
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: getChartColors.value.grid,
                drawBorder: false,
            },
            ticks: {
                color: getChartColors.value.text,
                font: {
                    size: 11,
                },
            },
        },
        x: {
            grid: {
                color: getChartColors.value.grid,
                drawBorder: false,
            },
            ticks: {
                color: getChartColors.value.text,
                font: {
                    size: 11,
                },
                maxTicksLimit: 8,
            },
        },
    },
    elements: {
        line: {
            borderWidth: 3,
        },
    },
    interaction: {
        intersect: false,
        mode: 'index' as const,
    },
}));

// Force chart update when dark mode changes
watch(isDarkMode, () => {
    // This will trigger a re-render when dark mode changes
});
</script>

<template>
    <div
        class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
    >
        <h3 class="mb-2 text-lg font-semibold text-foreground">Daily Activity Trend</h3>
        <div class="relative h-[calc(100%-2rem)]">
            <Line
                v-if="activitiesTrend?.length"
                :data="chartData"
                :options="chartOptions"
                :key="isDarkMode.toString()"
            />
            <div
                v-else
                class="flex h-full items-center justify-center text-muted-foreground"
            >
                No data available
            </div>
        </div>
    </div>
</template>
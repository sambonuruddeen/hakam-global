<script setup lang="ts">
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
    type ChartOptions,
    type ChartData,
} from 'chart.js';
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
);

interface FeederData {
    name: string;
    today: number;
    total: number;
}

const props = defineProps<{
    feeder_data: FeederData[];
}>();

// Dark mode reactive variable
const isDarkMode = computed(() => {
    return document.documentElement.classList.contains('dark');
});

// Colors that adapt to dark/light mode
const getChartColors = computed(() => {
    if (isDarkMode.value) {
        return {
            bar: 'hsl(210, 40%, 70%)', // Lighter bar color for dark mode
            grid: 'rgba(255, 255, 255, 0.1)',
            text: 'rgba(255, 255, 255, 0.8)',
            background: 'transparent'
        };
    } else {
        return {
            bar: 'hsl(var(--primary))',
            grid: 'rgba(0, 0, 0, 0.1)',
            text: 'rgba(0, 0, 0, 0.8)',
            background: 'transparent'
        };
    }
});

// Chart data for today's activity counts
const chartData = computed<ChartData<'bar'>>(() => ({
    labels: props.feeder_data.map((item) => item.name),
    datasets: [
        {
            label: "Today's Activity",
            backgroundColor: getChartColors.value.bar,
            borderColor: getChartColors.value.bar,
            data: props.feeder_data.map((item) => item.today),
            borderRadius: 6,
            borderSkipped: false,
        },
    ],
}));

const chartOptions = computed<ChartOptions<'bar'>>(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            labels: {
                color: getChartColors.value.text,
                font: {
                    size: 12,
                },
                boxWidth: 12,
                padding: 12,
                usePointStyle: true,
            }
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
                display: false,
            },
            ticks: {
                color: getChartColors.value.text,
                font: {
                    size: 11,
                },
            },
        },
    },
    interaction: {
        intersect: false,
        mode: 'index' as const,
    },
}));
</script>

<template>
    <div class="space-y-6 rounded-xl border border-sidebar-border/70 bg-card p-4 dark:border-sidebar-border">
        <!-- Bar Chart Section -->
        <div>
            <h3 class="mb-4 text-lg font-semibold text-foreground">Feeder Performance</h3>
            <div class="relative h-80 w-full">
                <Bar
                    v-if="feeder_data?.length"
                    :data="chartData"
                    :options="chartOptions"
                    :key="isDarkMode.toString()"
                />
                <div
                    v-else
                    class="flex h-full items-center justify-center text-muted-foreground"
                >
                    No feeder data available
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div>
            <h3 class="mb-3 text-sm font-semibold text-foreground">Feeder Activity Summary</h3>
            <div class="overflow-hidden rounded-lg border border-sidebar-border/50">
                <table class="w-full text-sm">
                    <thead class="border-b border-sidebar-border/50 bg-muted/40">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-foreground">Feeder</th>
                            <th class="px-4 py-3 text-right font-semibold text-foreground">Today</th>
                            <th class="px-4 py-3 text-right font-semibold text-foreground">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sidebar-border/30">
                        <tr
                            v-for="feeder in feeder_data"
                            :key="feeder.name"
                            class="transition-colors hover:bg-muted/20"
                        >
                            <td class="px-4 py-3 font-medium text-foreground">{{ feeder.name }}</td>
                            <td class="px-4 py-3 text-right text-foreground">{{ feeder.today }}</td>
                            <td class="px-4 py-3 text-right text-foreground">{{ feeder.total }}</td>
                        </tr>
                        <tr v-if="!feeder_data?.length">
                            <td colspan="3" class="px-4 py-8 text-center text-muted-foreground">
                                No feeder data available
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

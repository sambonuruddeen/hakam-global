<script setup lang="ts">
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
    type ChartData,
    type ChartOptions,
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

interface TeamData {
    name: string;
    today: number;
    total: number;
}

const props = defineProps<{
    teamData: TeamData[];
    darkMode?: boolean;
}>();

// Colors that adapt to dark/light mode with better contrast
const getChartColors = computed(() => {
    if (props.darkMode) {
        return {
            primary: 'hsl(210, 80%, 60%)', // Brighter blue for dark mode
            primaryLight: 'hsl(210, 80%, 70%)', // Even brighter for hover
            grid: 'rgba(255, 255, 255, 0.1)',
            text: 'rgba(255, 255, 255, 0.8)',
            background: 'transparent'
        };
    } else {
        return {
            primary: 'hsl(var(--primary))', // Your original primary color
            primaryLight: 'hsl(var(--primary) / 0.8)', // Slightly lighter for hover
            grid: 'rgba(0, 0, 0, 0.1)',
            text: 'rgba(0, 0, 0, 0.8)',
            background: 'transparent'
        };
    }
});

const chartData = computed<ChartData<'bar'>>(() => ({
    labels: props.teamData.map((item) => item.name),
    datasets: [
        {
            label: "Today's Activities",
            backgroundColor: getChartColors.value.primary,
            borderColor: getChartColors.value.primary,
            borderWidth: 0,
            data: props.teamData.map((item) => item.today),
            borderRadius: 4,
            barPercentage: 0.6,
            categoryPercentage: 0.8,
            hoverBackgroundColor: getChartColors.value.primaryLight,
            hoverBorderColor: getChartColors.value.primaryLight,
        },
    ],
}));

const chartOptions = computed<ChartOptions<'bar'>>(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
        },
        tooltip: {
            backgroundColor: props.darkMode ? 'rgba(30, 30, 30, 0.95)' : 'rgba(255, 255, 255, 0.95)',
            titleColor: props.darkMode ? 'rgba(255, 255, 255, 0.9)' : 'rgba(0, 0, 0, 0.9)',
            bodyColor: props.darkMode ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)',
            borderColor: props.darkMode ? 'rgba(255, 255, 255, 0.3)' : 'rgba(0, 0, 0, 0.2)',
            borderWidth: 1,
            cornerRadius: 6,
            displayColors: false,
            callbacks: {
                label: function(context) {
                    return `Today's Activities: ${context.parsed.y}`;
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
                precision: 0,
            },
        },
        x: {
            grid: {
                display: false,
                drawBorder: false,
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
    <div
        class="relative flex flex-col gap-4 overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
    >
        <h3 class="text-lg font-semibold text-foreground">Feeder Performance</h3>
        
        <!-- Bar Chart -->
        <div class="relative h-48">
            <Bar
                v-if="teamData?.length"
                :data="chartData"
                :options="chartOptions"
                :key="darkMode"
            />
            <div
                v-else
                class="flex h-full items-center justify-center text-muted-foreground"
            >
                No team data available
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-border">
                        <th class="p-2 font-medium text-muted-foreground bg-muted/50">
                            Distribution Transformer
                        </th>
                        <th class="p-2 text-right font-medium text-muted-foreground bg-muted/50">
                            Today
                        </th>
                        <th class="p-2 text-right font-medium text-muted-foreground bg-muted/50">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(member, index) in teamData"
                        :key="member.name"
                        class="transition-colors duration-150 hover:bg-muted/30"
                        :class="[
                            index < teamData.length - 1 ? 'border-b border-border' : '',
                            index % 2 === 0 ? 'bg-muted/20' : ''
                        ]"
                    >
                        <td class="p-2 font-medium text-foreground">{{ member.name }}</td>
                        <td class="p-2 text-right text-foreground">{{ member.today }}</td>
                        <td class="p-2 text-right text-foreground">{{ member.total }}</td>
                    </tr>
                </tbody>
            </table>
            <div
                v-if="!teamData?.length"
                class="flex items-center justify-center py-8 text-muted-foreground"
            >
                No team data available
            </div>
        </div>
    </div>
</template>
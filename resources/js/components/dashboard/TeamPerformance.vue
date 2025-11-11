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
}>();

const chartData = computed<ChartData<'bar'>>(() => ({
    labels: props.teamData.map((item) => item.name),
    datasets: [
        {
            label: "Today's Activities",
            backgroundColor: 'hsl(var(--primary))',
            data: props.teamData.map((item) => item.today),
        },
    ],
}));

const chartOptions: ChartOptions<'bar'> = {
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
            ticks: {
                precision: 0,
            },
        },
    },
};
</script>

<template>
    <div
        class="relative flex flex-col gap-4 overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
    >
        <h3 class="text-lg font-semibold">Feeder Performance</h3>
        <div class="relative h-48">
            <Bar
                v-if="teamData?.length"
                :data="chartData"
                :options="chartOptions"
            />
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b">
                    <tr>
                        <th class="p-2">Distribution Transformer</th>
                        <th class="p-2 text-right">Today</th>
                        <th class="p-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="member in teamData"
                        :key="member.name"
                        class="border-b last:border-none"
                    >
                        <td class="p-2 font-medium">{{ member.name }}</td>
                        <td class="p-2 text-right">{{ member.today }}</td>
                        <td class="p-2 text-right">{{ member.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<!-- 
Team Performance (Bar Chart & Table):

Component Name: TeamPerformance.vue
Visualization: A Bar Chart (or similar) comparing Today's activity counts for each team member, positioned above a simple Data Table showing Today and Total metrics for each user.
Data Input (Props): Expects a team_data prop: Array&lt;{name: string, today: number, total: number}&gt;.
Requirement: Use a common Vue charting library like Vue Chart.js or a simple charting solution.
-->
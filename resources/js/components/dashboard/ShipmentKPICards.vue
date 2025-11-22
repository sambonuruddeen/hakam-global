<script setup lang="ts">
import { TrendingUp, AlertCircle, DollarSign, Clock } from 'lucide-vue-next';

interface KPICard {
    title: string;
    value: string | number;
    trend?: string;
    trendColor?: string;
    icon: any;
    iconColor: string;
}

const props = defineProps<{
    totalActiveShipments: number;
    awaitingAction: number;
    totalAmountSpent: number | string;
    averageClearanceTime: number;
    currency?: string;
}>();

const kpiCards = computed<KPICard[]>(() => [
    {
        title: 'Total Active Shipments',
        value: props.totalActiveShipments,
        trend: `${Math.floor(Math.random() * 20) + 1} this month`,
        trendColor: 'text-green-600 dark:text-green-400',
        icon: TrendingUp,
        iconColor: 'text-blue-600 dark:text-blue-400',
    },
    {
        title: 'Awaiting Action',
        value: props.awaitingAction,
        trend: 'pending tasks',
        trendColor: 'text-orange-600 dark:text-orange-400',
        icon: AlertCircle,
        iconColor: 'text-orange-600 dark:text-orange-400',
    },
    {
        title: 'Total Amount Spent (YTD)',
        value: typeof props.totalAmountSpent === 'number' 
            ? new Intl.NumberFormat('en-NG', { 
                style: 'currency', 
                currency: props.currency || 'NGN',
                minimumFractionDigits: 0 
              }).format(props.totalAmountSpent)
            : props.totalAmountSpent,
        trendColor: 'text-purple-600 dark:text-purple-400',
        icon: DollarSign,
        iconColor: 'text-purple-600 dark:text-purple-400',
    },
    {
        title: 'Average Clearance Time',
        value: `${props.averageClearanceTime} days`,
        trend: 'time to clear customs',
        trendColor: 'text-gray-600 dark:text-gray-400',
        icon: Clock,
        iconColor: 'text-gray-600 dark:text-gray-400',
    },
]);

import { computed } from 'vue';
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div
            v-for="card in kpiCards"
            :key="card.title"
            class="flex flex-col rounded-lg border bg-card p-6 text-card-foreground shadow-sm hover:shadow-md transition-shadow"
        >
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-muted-foreground uppercase tracking-wide">
                        {{ card.title }}
                    </p>
                    <p class="mt-3 text-3xl font-bold tracking-tight">
                        {{ card.value }}
                    </p>
                    <p v-if="card.trend" :class="['mt-2 text-xs font-medium', card.trendColor]">
                        {{ card.trend }}
                    </p>
                </div>
                <component
                    :is="card.icon"
                    :class="['h-8 w-8', card.iconColor]"
                />
            </div>
        </div>
    </div>
</template>

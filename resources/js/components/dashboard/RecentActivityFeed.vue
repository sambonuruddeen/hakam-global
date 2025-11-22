<script setup lang="ts">
import { Clock, Anchor, Truck, DollarSign, CheckCircle, FileText } from 'lucide-vue-next';
import { computed } from 'vue';

interface ActivityUpdate {
    id: string;
    vin: string;
    model?: string;
    activity: string;
    description: string;
    timestamp: string;
    type: 'vessel' | 'duty' | 'driver' | 'delivery' | 'other';
    icon?: any;
}

const props = defineProps<{
    activities: ActivityUpdate[];
}>();

const getActivityIcon = (type: string) => {
    const iconMap: Record<string, any> = {
        vessel: Anchor,
        duty: DollarSign,
        driver: Truck,
        delivery: CheckCircle,
        other: FileText,
    };
    return iconMap[type] || Clock;
};

const getActivityColor = (type: string) => {
    const colorMap: Record<string, string> = {
        vessel: 'text-blue-600 dark:text-blue-400',
        duty: 'text-orange-600 dark:text-orange-400',
        driver: 'text-purple-600 dark:text-purple-400',
        delivery: 'text-green-600 dark:text-green-400',
        other: 'text-gray-600 dark:text-gray-400',
    };
    return colorMap[type] || colorMap.other;
};

const getActivityBgColor = (type: string) => {
    const colorMap: Record<string, string> = {
        vessel: 'bg-blue-50 dark:bg-blue-950/20',
        duty: 'bg-orange-50 dark:bg-orange-950/20',
        driver: 'bg-purple-50 dark:bg-purple-950/20',
        delivery: 'bg-green-50 dark:bg-green-950/20',
        other: 'bg-gray-50 dark:bg-gray-950/20',
    };
    return colorMap[type] || colorMap.other;
};

const recentActivities = computed(() => {
    return props.activities.slice(0, 5);
});

const timeAgo = (timestamp: string) => {
    const date = new Date(timestamp);
    const now = new Date();
    const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

    if (seconds < 60) return 'Just now';
    if (seconds < 3600) return `${Math.floor(seconds / 60)}m ago`;
    if (seconds < 86400) return `${Math.floor(seconds / 3600)}h ago`;
    if (seconds < 604800) return `${Math.floor(seconds / 86400)}d ago`;
    return date.toLocaleDateString();
};
</script>

<template>
    <div class="space-y-4">
        <h3 class="text-lg font-semibold flex items-center gap-2">
            <Clock class="h-5 w-5 text-gray-600" />
            Recent Activity / Order History
        </h3>

        <div v-if="recentActivities.length === 0" class="rounded-lg border border-dashed bg-card p-8 text-center">
            <Clock class="h-12 w-12 mx-auto mb-2 text-muted-foreground/50" />
            <p class="text-sm text-muted-foreground">No recent activity</p>
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="(activity, index) in recentActivities"
                :key="activity.id"
                class="rounded-lg border bg-card p-4 transition-all hover:shadow-md"
            >
                <div class="flex gap-4">
                    <!-- Timeline icon -->
                    <div class="relative flex flex-col items-center">
                        <div :class="['rounded-full p-2.5', getActivityBgColor(activity.type)]">
                            <component
                                :is="getActivityIcon(activity.type)"
                                :class="['h-5 w-5', getActivityColor(activity.type)]"
                            />
                        </div>
                        <!-- Timeline connector line -->
                        <div
                            v-if="index < recentActivities.length - 1"
                            class="mt-2 h-8 w-0.5 bg-muted-foreground/20"
                        />
                    </div>

                    <!-- Activity content -->
                    <div class="flex-1 min-w-0 py-1">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-semibold text-sm">{{ activity.activity }}</p>
                                <p class="text-xs text-muted-foreground mt-0.5">
                                    <span v-if="activity.model" class="font-medium">{{ activity.model }}</span>
                                    <span v-if="activity.model"> • </span>
                                    VIN: {{ activity.vin }}
                                </p>
                            </div>
                            <span class="text-xs font-medium text-muted-foreground whitespace-nowrap">
                                {{ timeAgo(activity.timestamp) }}
                            </span>
                        </div>
                        <p class="text-sm text-foreground/80 mt-2">{{ activity.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- View all button -->
        <button
            v-if="activities.length > 5"
            class="w-full mt-4 px-4 py-2 rounded-lg border border-muted hover:bg-muted/50 transition-colors text-sm font-medium"
        >
            View All Activity ({{ activities.length }} total)
        </button>
    </div>
</template>

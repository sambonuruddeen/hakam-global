<script setup lang="ts">
import { AlertTriangle, FileText, Phone, Clock } from 'lucide-vue-next';
import { computed } from 'vue';

interface Alert {
    id: string;
    type: 'payment' | 'document' | 'driver' | 'other';
    vin: string;
    title: string;
    description: string;
    urgency: 'critical' | 'high' | 'medium';
    timestamp?: string;
    actionUrl?: string;
}

const props = defineProps<{
    alerts: Alert[];
}>();

const alertsByType = computed(() => {
    return {
        payment: props.alerts.filter((a) => a.type === 'payment'),
        document: props.alerts.filter((a) => a.type === 'document'),
        driver: props.alerts.filter((a) => a.type === 'driver'),
        other: props.alerts.filter((a) => a.type === 'other'),
    };
});

const getAlertIcon = (type: string) => {
    const iconMap: Record<string, any> = {
        payment: AlertTriangle,
        document: FileText,
        driver: Phone,
        other: Clock,
    };
    return iconMap[type] || Clock;
};

const getAlertColor = (urgency: string) => {
    const colorMap: Record<string, string> = {
        critical: 'border-red-200 bg-red-50 dark:border-red-900/30 dark:bg-red-950/20',
        high: 'border-orange-200 bg-orange-50 dark:border-orange-900/30 dark:bg-orange-950/20',
        medium: 'border-yellow-200 bg-yellow-50 dark:border-yellow-900/30 dark:bg-yellow-950/20',
    };
    return colorMap[urgency] || colorMap.medium;
};

const getUrgencyBadgeColor = (urgency: string) => {
    const colorMap: Record<string, string> = {
        critical: 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
        high: 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
        medium: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
    };
    return colorMap[urgency] || colorMap.medium;
};

const totalAlerts = computed(() => props.alerts.length);
const criticalCount = computed(() => props.alerts.filter((a) => a.urgency === 'critical').length);
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <AlertTriangle class="h-5 w-5 text-red-600" />
                Critical Alerts & Pending Actions
            </h3>
            <span v-if="totalAlerts > 0" class="inline-flex items-center gap-1">
                <span class="text-sm font-medium">
                    {{ totalAlerts }} alert<span v-if="totalAlerts !== 1">s</span>
                </span>
                <span v-if="criticalCount > 0" class="inline-block ml-1 h-2 w-2 rounded-full bg-red-600 animate-pulse" />
            </span>
        </div>

        <div v-if="totalAlerts === 0" class="rounded-lg border border-dashed bg-card p-8 text-center">
            <AlertTriangle class="h-12 w-12 mx-auto mb-2 text-muted-foreground/50" />
            <p class="text-sm text-muted-foreground">No pending alerts</p>
        </div>

        <!-- Payment Due Alerts -->
        <div v-if="alertsByType.payment.length > 0" class="space-y-2">
            <h4 class="text-sm font-semibold text-red-700 dark:text-red-400 flex items-center gap-2 px-1">
                <AlertTriangle class="h-4 w-4" />
                Payment Due
            </h4>
            <div
                v-for="alert in alertsByType.payment"
                :key="alert.id"
                :class="['rounded-lg border p-3 transition-all hover:shadow-md', getAlertColor(alert.urgency)]"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5">
                        <component :is="getAlertIcon(alert.type)" class="h-5 w-5 text-red-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-medium text-sm">{{ alert.title }}</p>
                                <p class="text-xs text-muted-foreground mt-1">VIN: {{ alert.vin }}</p>
                            </div>
                            <span :class="['inline-flex items-center rounded px-2 py-1 text-xs font-semibold', getUrgencyBadgeColor(alert.urgency)]">
                                {{ alert.urgency.toUpperCase() }}
                            </span>
                        </div>
                        <p class="text-sm mt-2 text-foreground/90">{{ alert.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Needed Alerts -->
        <div v-if="alertsByType.document.length > 0" class="space-y-2">
            <h4 class="text-sm font-semibold text-orange-700 dark:text-orange-400 flex items-center gap-2 px-1">
                <FileText class="h-4 w-4" />
                Documents Needed
            </h4>
            <div
                v-for="alert in alertsByType.document"
                :key="alert.id"
                :class="['rounded-lg border p-3 transition-all hover:shadow-md', getAlertColor(alert.urgency)]"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5">
                        <component :is="getAlertIcon(alert.type)" class="h-5 w-5 text-orange-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-medium text-sm">{{ alert.title }}</p>
                                <p class="text-xs text-muted-foreground mt-1">VIN: {{ alert.vin }}</p>
                            </div>
                            <span :class="['inline-flex items-center rounded px-2 py-1 text-xs font-semibold', getUrgencyBadgeColor(alert.urgency)]">
                                {{ alert.urgency.toUpperCase() }}
                            </span>
                        </div>
                        <p class="text-sm mt-2 text-foreground/90">{{ alert.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver Contact Alerts -->
        <div v-if="alertsByType.driver.length > 0" class="space-y-2">
            <h4 class="text-sm font-semibold text-blue-700 dark:text-blue-400 flex items-center gap-2 px-1">
                <Phone class="h-4 w-4" />
                Driver Contact
            </h4>
            <div
                v-for="alert in alertsByType.driver"
                :key="alert.id"
                :class="['rounded-lg border p-3 transition-all hover:shadow-md', getAlertColor(alert.urgency)]"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5">
                        <component :is="getAlertIcon(alert.type)" class="h-5 w-5 text-blue-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-medium text-sm">{{ alert.title }}</p>
                                <p class="text-xs text-muted-foreground mt-1">VIN: {{ alert.vin }}</p>
                            </div>
                            <span :class="['inline-flex items-center rounded px-2 py-1 text-xs font-semibold', getUrgencyBadgeColor(alert.urgency)]">
                                {{ alert.urgency.toUpperCase() }}
                            </span>
                        </div>
                        <p class="text-sm mt-2 text-foreground/90">{{ alert.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

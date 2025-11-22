<script setup lang="ts">
import { MapPin, TrendingDown, Navigation } from 'lucide-vue-next';
import { computed } from 'vue';

interface Shipment {
    vin: string;
    status: 'ordered' | 'in_transit' | 'at_port' | 'last_mile' | 'delivered';
    eta?: string;
    location?: string;
}

interface UpcomingDelivery {
    vin: string;
    model: string;
    eta: string;
    daysUntilArrival: number;
    status: string;
}

const props = defineProps<{
    shipments: Shipment[];
    upcomingDeliveries: UpcomingDelivery[];
}>();

const statusDistribution = computed(() => {
    const distribution = {
        ordered: 0,
        in_transit: 0,
        at_port: 0,
        last_mile: 0,
        delivered: 0,
    };

    props.shipments.forEach((shipment) => {
        distribution[shipment.status]++;
    });

    return distribution;
});

const statusLabels = {
    ordered: 'Ordered (Awaiting Pickup)',
    in_transit: 'In Transit (On Vessel)',
    at_port: 'At Port (Awaiting Clearance)',
    last_mile: 'Last-Mile Delivery',
    delivered: 'Delivered',
};

const statusColors = {
    ordered: '#3b82f6',        // Blue
    in_transit: '#f59e0b',     // Amber
    at_port: '#ef4444',        // Red
    last_mile: '#8b5cf6',      // Purple
    delivered: '#10b981',      // Green
};

const chartData = computed(() => {
    const total = props.shipments.length || 1;
    return [
        {
            label: 'Ordered',
            value: statusDistribution.value.ordered,
            percentage: Math.round((statusDistribution.value.ordered / total) * 100),
            color: statusColors.ordered,
        },
        {
            label: 'In Transit',
            value: statusDistribution.value.in_transit,
            percentage: Math.round((statusDistribution.value.in_transit / total) * 100),
            color: statusColors.in_transit,
        },
        {
            label: 'At Port',
            value: statusDistribution.value.at_port,
            percentage: Math.round((statusDistribution.value.at_port / total) * 100),
            color: statusColors.at_port,
        },
        {
            label: 'Last-Mile',
            value: statusDistribution.value.last_mile,
            percentage: Math.round((statusDistribution.value.last_mile / total) * 100),
            color: statusColors.last_mile,
        },
        {
            label: 'Delivered',
            value: statusDistribution.value.delivered,
            percentage: Math.round((statusDistribution.value.delivered / total) * 100),
            color: statusColors.delivered,
        },
    ].filter((item) => item.value > 0);
});
</script>

<template>
    <div class="space-y-6">
        <!-- Real-Time Map Section -->
        <div class="flex flex-col gap-4 lg:flex-row">
            <!-- Mini Map -->
            <div class="flex-1 rounded-lg border bg-card p-6">
                <h3 class="mb-4 text-lg font-semibold flex items-center gap-2">
                    <MapPin class="h-5 w-5 text-blue-600" />
                    Real-Time Shipment Map
                </h3>
                <div class="h-64 w-full rounded-md bg-muted flex items-center justify-center">
                    <div class="text-center">
                        <MapPin class="h-12 w-12 mx-auto mb-2 text-muted-foreground" />
                        <p class="text-sm text-muted-foreground">Map integration coming soon</p>
                        <p class="text-xs text-muted-foreground mt-1">
                            {{ shipments.length }} active shipments
                        </p>
                    </div>
                </div>
            </div>

            <!-- Shipment Status Funnel -->
            <div class="flex-1 rounded-lg border bg-card p-6">
                <h3 class="mb-4 text-lg font-semibold flex items-center gap-2">
                    <TrendingDown class="h-5 w-5 text-purple-600" />
                    Shipment Status Distribution
                </h3>
                <div class="space-y-4">
                    <div v-for="item in chartData" :key="item.label" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">{{ item.label }}</span>
                            <span class="text-sm font-semibold">{{ item.value }} ({{ item.percentage }}%)</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-muted overflow-hidden">
                            <div
                                class="h-full transition-all duration-500"
                                :style="{ width: `${item.percentage}%`, backgroundColor: item.color }"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming ETA/Deliveries Section -->
        <div class="rounded-lg border bg-card p-6">
            <h3 class="mb-4 text-lg font-semibold flex items-center gap-2">
                <Navigation class="h-5 w-5 text-green-600" />
                Upcoming ETAs & Deliveries
            </h3>
            <div v-if="upcomingDeliveries.length === 0" class="text-center py-8">
                <p class="text-muted-foreground">No upcoming deliveries</p>
            </div>
            <div v-else class="space-y-3">
                <div
                    v-for="delivery in upcomingDeliveries.slice(0, 5)"
                    :key="delivery.vin"
                    class="flex items-center justify-between rounded-md border border-muted p-3 hover:bg-muted/50 transition-colors"
                >
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ delivery.model }}</p>
                        <p class="text-xs text-muted-foreground">VIN: {{ delivery.vin }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold">{{ delivery.eta }}</p>
                        <p class="text-xs text-blue-600 font-medium">
                            {{ delivery.daysUntilArrival }} days away
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

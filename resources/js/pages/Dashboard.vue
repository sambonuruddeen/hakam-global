<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import ShipmentKPICards from '@/components/dashboard/ShipmentKPICards.vue';
import ShipmentTrackingOverview from '@/components/dashboard/ShipmentTrackingOverview.vue';
import CriticalAlerts from '@/components/dashboard/CriticalAlerts.vue';
import RecentActivityFeed from '@/components/dashboard/RecentActivityFeed.vue';

import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const pageProps = defineProps<{
    totalActiveShipments?: number;
    awaitingAction?: number;
    totalAmountSpent?: number;
    averageClearanceTime?: number;
}>();

// Mock data - Replace with real data from backend
const kpiMetrics = {
    totalActiveShipments: 12,
    awaitingAction: 5,
    totalAmountSpent: 2500000,
    averageClearanceTime: 7,
};

const mockShipments = [
    { vin: 'ABC123456789', status: 'in_transit' as const, location: 'At Sea' },
    { vin: 'DEF987654321', status: 'at_port' as const, location: 'Lagos Port' },
    { vin: 'GHI456789123', status: 'last_mile' as const, location: 'In Transit to Customer' },
    { vin: 'JKL789123456', status: 'delivered' as const },
    { vin: 'MNO123456789', status: 'ordered' as const, location: 'Awaiting Pickup' },
    { vin: 'PQR654321987', status: 'in_transit' as const, location: 'At Sea' },
    { vin: 'STU321987654', status: 'at_port' as const, location: 'Lagos Port' },
    { vin: 'VWX789456123', status: 'ordered' as const, location: 'Awaiting Pickup' },
    { vin: 'YZA456123789', status: 'in_transit' as const, location: 'At Sea' },
    { vin: 'BCD987123456', status: 'last_mile' as const, location: 'In Transit to Customer' },
    { vin: 'EFG234567890', status: 'at_port' as const, location: 'Lagos Port' },
    { vin: 'HIJ567890123', status: 'delivered' as const },
];

const mockUpcomingDeliveries = [
    { vin: 'ABC123456789', model: 'Toyota Camry 2023', eta: '2025-11-28', daysUntilArrival: 6, status: 'In Transit' },
    { vin: 'DEF987654321', model: 'Honda Civic 2022', eta: '2025-11-25', daysUntilArrival: 3, status: 'At Port' },
    { vin: 'GHI456789123', model: 'BMW 3 Series 2023', eta: '2025-11-24', daysUntilArrival: 2, status: 'Last Mile' },
    { vin: 'JKL789123456', model: 'Mercedes-Benz C-Class 2023', eta: '2025-11-23', daysUntilArrival: 1, status: 'Delivery Today' },
    { vin: 'PQR654321987', model: 'Ford Mustang 2023', eta: '2025-12-02', daysUntilArrival: 10, status: 'In Transit' },
];

const mockAlerts = [
    {
        id: '1',
        type: 'payment' as const,
        vin: 'DEF987654321',
        title: 'Customs Duty Payment Due',
        description: 'Duty payment of ₦1,230,000 is due for VIN DEF987654321 (Honda Civic 2022)',
        urgency: 'critical' as const,
        timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000).toISOString(),
    },
    {
        id: '2',
        type: 'document' as const,
        vin: 'ABC123456789',
        title: 'Proof of Ownership Required',
        description: 'Please upload proof of ownership documentation for vehicle ABC123456789',
        urgency: 'high' as const,
        timestamp: new Date(Date.now() - 4 * 60 * 60 * 1000).toISOString(),
    },
    {
        id: '3',
        type: 'document' as const,
        vin: 'GHI456789123',
        title: 'Form M Missing',
        description: 'Customs Form M is missing for shipment GHI456789123. Please provide ASAP.',
        urgency: 'high' as const,
        timestamp: new Date(Date.now() - 6 * 60 * 60 * 1000).toISOString(),
    },
    {
        id: '4',
        type: 'driver' as const,
        vin: 'GHI456789123',
        title: 'Driver Confirmation Needed',
        description: 'Driver Chinedu Okafor has been assigned. Please confirm delivery details.',
        urgency: 'medium' as const,
        timestamp: new Date(Date.now() - 8 * 60 * 60 * 1000).toISOString(),
    },
    {
        id: '5',
        type: 'payment' as const,
        vin: 'JKL789123456',
        title: 'Final Clearance Fee Due',
        description: 'Final customs clearance fee of ₦450,000 is pending',
        urgency: 'medium' as const,
        timestamp: new Date(Date.now() - 12 * 60 * 60 * 1000).toISOString(),
    },
];

const mockActivityFeed = [
    {
        id: '1',
        vin: 'ABC123456789',
        model: 'Toyota Camry 2023',
        activity: 'Vessel Departed',
        description: 'Vessel Maersk Horizon departed port with your shipment',
        timestamp: new Date(Date.now() - 1 * 60 * 60 * 1000).toISOString(),
        type: 'vessel' as const,
    },
    {
        id: '2',
        vin: 'DEF987654321',
        model: 'Honda Civic 2022',
        activity: 'Duty Calculated',
        description: 'Customs duty has been calculated at ₦1,230,000',
        timestamp: new Date(Date.now() - 3 * 60 * 60 * 1000).toISOString(),
        type: 'duty' as const,
    },
    {
        id: '3',
        vin: 'GHI456789123',
        model: 'BMW 3 Series 2023',
        activity: 'Driver Assigned',
        description: 'Chinedu Okafor has been assigned as the delivery driver',
        timestamp: new Date(Date.now() - 5 * 60 * 60 * 1000).toISOString(),
        type: 'driver' as const,
    },
    {
        id: '4',
        vin: 'JKL789123456',
        model: 'Mercedes-Benz C-Class 2023',
        activity: 'Delivery Completed',
        description: 'Package has been successfully delivered to the customer',
        timestamp: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString(),
        type: 'delivery' as const,
    },
    {
        id: '5',
        vin: 'MNO123456789',
        model: 'Audi A4 2023',
        activity: 'Documentation Uploaded',
        description: 'Proof of ownership and registration documents have been uploaded',
        timestamp: new Date(Date.now() - 48 * 60 * 60 * 1000).toISOString(),
        type: 'other' as const,
    },
];

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4 md:p-6">
            <!-- Section 1: High-Level Status & Key Metrics (KPI Cards) -->
            <section class="space-y-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold tracking-tight">KPI Overview</h2>
                </div>
                <ShipmentKPICards
                    :total-active-shipments="kpiMetrics.totalActiveShipments"
                    :awaiting-action="kpiMetrics.awaitingAction"
                    :total-amount-spent="kpiMetrics.totalAmountSpent"
                    :average-clearance-time="kpiMetrics.averageClearanceTime"
                    currency="NGN"
                />
            </section>

            <!-- Section 2: Shipment Tracking Overview (Interactive Map/Table) -->
            <section class="space-y-2">
                <h2 class="text-2xl font-bold tracking-tight">Shipment Tracking</h2>
                <ShipmentTrackingOverview
                    :shipments="mockShipments"
                    :upcoming-deliveries="mockUpcomingDeliveries"
                />
            </section>

            <!-- Section 3 & 4: Critical Alerts and Recent Activity (2-column layout) -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Section 3: Critical Alerts & Pending Actions -->
                <section class="rounded-lg border bg-card p-6">
                    <CriticalAlerts :alerts="mockAlerts" />
                </section>

                <!-- Section 4: Recent Activity / Order History -->
                <section class="rounded-lg border bg-card p-6">
                    <RecentActivityFeed :activities="mockActivityFeed" />
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
// In a real application, you would pass these stats as props.
const stats = {
    totalCompleted: '4,821',
    completedVsTarget: '+1,250',
    remainingPercentage: '79%',
    completedToday: '58',
    startedToday: '210',
};
</script>

<template>
    <div
        class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
        data-testid="summary-stats-grid"
    >
        <!-- Total Activities Completed -->
        <div
            class="flex flex-col rounded-xl border bg-card p-4 text-card-foreground"
        >
            <h3 class="text-xs font-semibold uppercase text-muted-foreground">
                Total Activities Completed
            </h3>
            <div class="mt-2 flex items-baseline gap-2">
                <p class="text-2xl font-bold tracking-tight">
                    {{ stats.totalCompleted }}
                </p>
                <span
                    class="rounded-md bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-800 dark:bg-green-900/50 dark:text-green-300"
                >
                    {{ stats.completedVsTarget }}
                </span>
            </div>
        </div>

        <!-- Total Remaining Activities -->
        <div
            class="flex flex-col rounded-xl border bg-card p-4 text-card-foreground"
        >
            <h3 class="text-xs font-semibold uppercase text-muted-foreground">
                Total Remaining Activities
            </h3>
            <p class="mt-2 text-2xl font-bold tracking-tight text-red-600 dark:text-red-500">
                {{ stats.remainingPercentage }}
            </p>
        </div>

        <!-- Activities Completed Today -->
        <div
            class="flex flex-col rounded-xl border bg-card p-4 text-card-foreground"
        >
            <h3 class="text-xs font-semibold uppercase text-muted-foreground">
                Activities Completed Today
            </h3>
            <p class="mt-2 text-2xl font-bold tracking-tight">{{ stats.completedToday }}</p>
        </div>

        <!-- Activities Started Today -->
        <div
            class="flex flex-col rounded-xl border bg-card p-4 text-card-foreground"
        >
            <h3 class="text-xs font-semibold uppercase text-muted-foreground">
                Activities Started Today
            </h3>
            <p class="mt-2 text-2xl font-bold tracking-tight">{{ stats.startedToday }}</p>
        </div>
    </div>
</template>
@media (max-width: 1024px) {
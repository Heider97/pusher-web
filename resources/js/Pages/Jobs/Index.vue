<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    jobs: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <AppLayout title="Jobs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Jobs
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="table-reponsive bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Queue
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Payload
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Attemps
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Created At
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="job in jobs" :key="job.id">
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm leading-5 text-gray-900 dark:text-gray-200">{{ job.queue }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm leading-5 text-gray-900 dark:text-gray-200">{{ job.payload.substring(0, 100) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap overflow-hidden text-ellipsis border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm leading-5 text-gray-900 dark:text-gray-200">{{ job.attempts }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm leading-5 text-gray-900 dark:text-gray-200">{{ job.created_at }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
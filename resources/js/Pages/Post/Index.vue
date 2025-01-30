<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    posts: {
        type: Array,
        required: true
    }
});

</script>

<template>
    <AppLayout title="Posts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Created At
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts" :key="post.id">
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900 dark:text-gray-200">
                                                {{ post.title }}
                                            </div>
                                            <div class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                                                {{ post.content }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm leading-5 text-gray-900 dark:text-gray-200">{{ post.created_at }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { defineEmits } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    posts: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['editPost', 'deletePost']);

const editPost = (post) => {
    emit('editPost', post);
};

const storePost = (post) => {
    axios.post('/posts', post)
        .then(() => {
            window.location.reload();
        })
        .catch((error) => {
            console.log(error);
        });
};

const deletePost = (postId) => {
    if (confirm('¿Seguro que deseas eliminar este post?')) {
        axios.delete(`/posts/${postId}`)
            .then(() => {
                window.location.reload();
            })
            .catch((error) => {
                console.log(error);
            });
    }
};
</script>

<template>
    <AppLayout title="Posts">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Posts
                </h2>

                <button @click="storePost({ title: 'Nuevo Post', content: 'Contenido del nuevo post', user_id: 1 })"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 mr-2">
                    Guardar Post
                </button>
            </div>


        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Created At
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts" :key="post.id">
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                {{ post.title }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ post.content }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm text-gray-900 dark:text-gray-200">{{ post.created_at }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                                    <button @click="editPost(post)"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 mr-2">
                                        Editar
                                    </button>
                                    <button @click="deletePost(post.id)"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
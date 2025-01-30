<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    posts: {
        type: Array,
        required: true
    }
});

const editingPost = ref(null);
const editForm = ref({
    title: '',
    content: ''
});

const startEdit = (post) => {
    editingPost.value = post;
    editForm.value = { title: post.title, content: post.content };
};

const storePost = async (post) => {
    try {
        const response = await axios.post('/posts', post);
        alert(response.data.message);
        window.location.reload(); // Recargar la página para actualizar la tabla
    } catch (error) {
        console.error('Error al guardar el post:', error);
        alert('Hubo un problema al guardar el post.');
    }
};

const updatePost = async () => {
    try {
        const response = await axios.put(`/posts/${editingPost.value.id}`, editForm.value);
        alert(response.data.message);
        window.location.reload(); // Recargar la página para actualizar la tabla
    } catch (error) {
        console.error('Error al actualizar el post:', error);
        alert('Hubo un problema al actualizar el post.');
    }
};

const deletePost = async (postId) => {
    if (confirm('¿Seguro que deseas eliminar este post?')) {
        try {
            const response = await axios.delete(`/posts/${postId}`);
            alert(response.data.message);
            window.location.reload(); // Recargar la página para actualizar la tabla
        } catch (error) {
            console.error('Error al eliminar el post:', error);
            alert('Hubo un problema al eliminar el post.');
        }
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
                                    <button @click="startEdit(post)"
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

                <!-- Modal de edición -->
                <div v-if="editingPost" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
                        <h3 class="text-lg font-semibold mb-4">Editar Post</h3>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                        <input v-model="editForm.title" type="text"
                            class="w-full border-gray-300 rounded-md shadow-sm mt-1 p-2 dark:bg-gray-700 dark:text-white">

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">Contenido</label>
                        <textarea v-model="editForm.content"
                            class="w-full border-gray-300 rounded-md shadow-sm mt-1 p-2 dark:bg-gray-700 dark:text-white"></textarea>

                        <div class="flex justify-end mt-4">
                            <button @click="editingPost = null"
                                class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-md hover:bg-gray-300">
                                Cancelar
                            </button>
                            <button @click="updatePost"
                                class="px-4 py-2 ml-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
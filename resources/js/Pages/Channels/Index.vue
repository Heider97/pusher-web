<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from "vue";
import axios from "axios";

const channels = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchChannels = async () => {
  try {
    const response = await axios.get("channels/active-users");
    channels.value = response.data;
  } catch (err) {
    error.value = "Error al cargar los canales.";
  } finally {
    loading.value = false;
  }
};

onMounted(fetchChannels);
</script>

<template>
  <AppLayout title="Channels">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Channels
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="table-reponsive bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div v-if="loading" class="text-center text-gray-500">Cargando...</div>
          <div v-else-if="error" class="text-red-500 text-center">{{ error }}</div>
          <div v-else>
            <table class="w-full border-collapse border border-gray-200">
              <thead>
                <tr class="bg-gray-200">
                  <th class="border px-4 py-2 text-left">Canal</th>
                  <th class="border px-4 py-2 text-left">Usuarios Activos</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="channel in channels" :key="channel.id">
                  <td class="border px-4 py-2 font-medium text-gray-700">{{ channel.name }}</td>
                  <td class="border px-4 py-2">
                    <ul v-if="channel.users.length > 0">
                      <li v-for="user in channel.users" :key="user.id" class="text-gray-600">{{ user.name }}</li>
                    </ul>
                    <span v-else class="text-gray-400">Sin usuarios activos</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>

</template>
<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['check', 'playerAdded']);
const newPlayer = ref('');

const addPlayer = () => {
  if (newPlayer.value) {
    emit('playerAdded', newPlayer.value); // Emit only the new player's name
    newPlayer.value = ''; // Clear the input
  }
};
</script>

<template>
  <div class="flex flex-col gap-4 mr-5 ml-5 mt-5">
    <div class="flex flex-row gap-4 mr-5 ml-5 mt-5">
      <input v-model="newPlayer" type="text" placeholder="Type here"
             class="input input-bordered input-warning w-full max-w-xs mb-2" />
      <button class="btn btn-warning w-1/12" @click="addPlayer">Add name</button>
    </div>
  </div>
</template>

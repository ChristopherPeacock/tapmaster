<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['check', 'playerAdded']);
const newPlayer = ref('');

const addPlayer = () => {
  if (newPlayer.value) {
    emit('playerAdded', {
      name: newPlayer.value
    });
    newPlayer.value = ''; 
  }
};

</script>

<template>
  <form @submit.prevent="addPlayer">
    <div class="flex flex-col gap-4 mr-5 ml-5 mt-5">
      <div class="flex flex-row gap-4 mr-5 ml-5 mt-5">
          <input v-model="newPlayer" type="text" placeholder="Type here"
                class="input input-bordered input-warning w-full mb-2" />
          <button class="btn btn-warning ">Add name</button>
      </div>
    </div>
  </form>
</template>

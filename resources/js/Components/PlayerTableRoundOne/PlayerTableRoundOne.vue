<!-- <script setup>
import { defineProps } from 'vue';
const { players } = defineProps(['players']);

</script>

<template>
    <div class="card bg-base-100 w-96 shadow-xl ml-10 mt-10" v-for="(player, index) in players" :key="index">
        <div class="card-body">
            <div class="card-actions justify-end mb-5 ml-8">
                <div class="avatar ml-5">
                    <div class="w-24 rounded-full">
                        <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <p class="card-title justify-center text-3xl mt-8 mr-6 ">{{ player.name }}</p>
            </div>
            <div class="flex justify-center row-auto ">
                <button class="btn btn-outline btn-success mr-10">Win</button>
                <button class="btn btn-outline btn-error ml-10">Lose</button>
            </div>

        </div>
    </div>

    <div class="flex w-full flex-col border-opacity-50" v-for="(player, index) in players" :key="index">
        <div class="card bg-base-300 rounded-box grid h-20 place-items-center">{{ player.name }}</div>
        <div class="divider">VS</div>
    </div>

</template> -->

<script setup>
import { computed, defineProps } from 'vue';

// Define props
const { players } = defineProps(['players']);

// Create a computed property to generate pairs
const playerPairs = computed(() => {
  const pairs = [];
  for (let i = 0; i < players.length; i += 2) {
    pairs.push([players[i], players[i + 1] || '']); // Handle odd numbers
  }
  return pairs;
});
</script>

<template>
  <div class="flex w-full flex-col border-opacity-50 mt-5 w-1/3 ml-5">
    <template v-for="(pair, index) in playerPairs" :key="index">
      <div class="card bg-base-300 rounded-box grid h-20 place-items-center  bg-slate-800">{{ pair[0].name }}</div>
      <div class="divider divider-primary">VS</div>
      <div class="card bg-base-300 rounded-box grid h-20 place-items-center  bg-slate-800">{{ pair[1].name }}</div>
      <br>
    </template>
  </div>
</template>

<script setup>
import { computed, defineProps, ref, defineEmits } from 'vue';

const { players } = defineProps({
    players: {
        required: true,
        type: Array
    }
});

const emit = defineEmits(['win']);

const won = ref([]);

const lose = ref([]);

const playersPaired = computed(() => {
    const pairs = [];
    for (let i = 0; i < players.length; i += 2) {
        pairs.push([players[i], players[i + 1] || '']);
    }
    return pairs;
});

const playerHasBeenProcessed = (player) => won.value.includes(player) || lose.value.includes(player);

const playerHasNotBeenProcessed = (player) => !playerHasBeenProcessed(player);

const addWin = (player) => {

    if (playerHasNotBeenProcessed(player)) {
        won.value.push(player);
        emitWin(player);
    }
};

const addLose = (player) => {
    if (playerHasNotBeenProcessed(player)) {
        lose.value.push(playerName);
    }
};

const unDo = (playerName) => {
    if (won.value.includes(playerName)) {
        won.value.splice(won.value.indexOf(playerName), 1);

    } else if (lose.value.includes(playerName)) {
        lose.value.splice(lose.value.indexOf(playerName), 1);
    }
};

const emitWin = (player) => {
    emit('win', player);
};

</script>


<template>
    <div v-for="(playerPair, index) in playersPaired" :key="index">
        <!-- Player 1 Card -->
        <div class="card rounded-box flex flex-row mt-5 h-20 place-items-center bg-slate-800"> <!-- Increased height -->
            <div class="avatar ml-2">
                <div class="w-14 rounded-xl"> <!-- Increased avatar size for consistency -->
                    <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <div class="ml-10">
                {{ playerPair[0].name || 'Waiting result' }}
            </div>
            <div class="ml-auto dropdown dropdown-hover flex">
                <div tabindex="0" role="button" class="btn mr-5 m-1">Decision</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li @click="addWin(playerPair[0])"><a>win</a></li>
                    <li @click="addLose(playerPair[0])"><a>lose</a></li>
                    <li @click="unDo(playerPair[0])"><a>Undo</a></li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="divider divider-primary">
            VS
        </div>

        <!-- Player 2 Card -->
        <div class="card rounded-box flex flex-row h-20 place-items-center bg-slate-800"> <!-- Increased height -->
            <div class="avatar ml-2">
                <div class="w-14 rounded-xl"> <!-- Made size consistent with Player 1 -->
                    <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <div class="ml-10 ">
                {{ playerPair[1].name || 'Waiting result' }}
            </div>
            <div class="ml-auto dropdown dropdown-hover flex">
                <div tabindex="0" role="button" class="btn mr-5 m-1">Decision</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li @click="addWin(playerPair[1])"><a>win</a></li>
                    <li @click="addLose(playerPair[1])"><a>lose</a></li>
                    <li @click="unDo(playerPair[1])"><a>Undo</a></li>
                </ul>
            </div>
        </div>
        <br>
    </div>
</template>

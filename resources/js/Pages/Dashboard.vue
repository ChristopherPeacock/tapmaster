<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Navbar from '@/Components/Navbar/Navbar.vue';
import AddPlayers from '@/Components/AddPlayer/AddPlayers.vue';
import Footer from '@/Components/Footer/Footer.vue';
import PlayerRound from '@/Components/PlayerTableRoundOne/PlayerRound.vue';


const buildRounds = (numRounds) => {
    

    const rounds = [];
    for (let i = 0; i < numRounds; i++) {
        rounds.push({
            players: [],
            winners: [],
            losers: []
        });
    }

    return rounds;
}

const rounds = ref(buildRounds(3));

const setRounds = () =>{
    console.log(rounds)
}

setRounds()

const handlePlayerAdded = (player) => {
    rounds.value[0].players.push(player);
};

const getNextRound = (round) => {
    let index = rounds.value.indexOf(round);
    return rounds.value[index + 1];
}

const handleWinForRound = (round, player) => {
    round.winners.push(player);
    const nextRound = getNextRound(round);
    if (nextRound) {
        nextRound.players.push(player);
    }
    else {
        alert('Winner: ' + player.name);
    }
}

const addPlayerToRound = (player, round) => {
    round.players.push(player);
};

const getRoundStyle = (index) => {
    const marginTopValue = index > 0 ? 175 + (index - 1) * 175 : 0; 
    const marginBottomValue = index > 0 ? 200 + (index - 1) * 250 : 0; 

    return {
        marginTop: `${marginTopValue}px`,
        marginBottom: `${marginBottomValue}px`
    };
};

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Navbar />
        <AddPlayers class="w-1/4" @playerAdded="addPlayerToRound($event, rounds[0])" />
        <div class="flex flex-row">
            <div v-for="(round, index) in rounds" class="flex flex-col w-1/4 gap-3 mx-2 ml-10" :key="round"
            :style="getRoundStyle(index)">
                <PlayerRound :players="round.players" @win="handleWinForRound(round, $event)"/>
                <AddPlayers v-if="round.players.length && index != 0" @playerAdded="addPlayerToRound($event, round)" />
            </div>
        </div>
    </AuthenticatedLayout>
    <Footer />
</template>

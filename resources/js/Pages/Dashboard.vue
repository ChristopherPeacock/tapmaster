<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Navbar from '@/Components/Navbar/Navbar.vue';
import AddPlayers from '@/Components/AddPlayer/AddPlayers.vue';
import Footer from '@/Components/Footer/Footer.vue';
import PlayerTableRoundOne from '@/Components/PlayerTableRoundOne/PlayerTableRoundOne.vue';


const playerList = ref([]);

const handlePlayerAdded = (playerData) => {
    playerList.value.push({ name: playerData });
};

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Navbar/>
        <AddPlayers @playerAdded="handlePlayerAdded"/>
        <PlayerTableRoundOne v-bind:players="playerList"/>
    </AuthenticatedLayout>
    <Footer />
</template>

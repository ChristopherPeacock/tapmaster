<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const webcamVideo = ref(null);
let mediaStream = null;

const startWebcam = async () => {
    try {
        mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
        if (webcamVideo.value) {
            webcamVideo.value.srcObject = mediaStream;
        }
    } catch (error) {
        console.error("Error accessing webcam:", error);
    }
};

const stopWebcam = () => {
    if (mediaStream) {
        const tracks = mediaStream.getTracks();
        tracks.forEach(track => track.stop());
        mediaStream = null;
        if (webcamVideo.value) {
            webcamVideo.value.srcObject = null;
        }
    }
};

onMounted(() => {
    startWebcam();
});

onBeforeUnmount(() => {
    stopWebcam();
});
</script>

<template>
    <div>
        <video ref="webcamVideo" autoplay playsinline width="640" height="480"></video>
    </div>
</template>

<style scoped>
video {
    border: 1px solid black;
}
</style>
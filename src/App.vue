<template>
    <router-view></router-view>
</template>

<script>
    export default {

    };

    window.addEventListener('load', () => {
        const preloadedElems = Array.from(document.querySelectorAll('.preload'));
        preloadedElems.forEach(elem => elem.classList.remove('preload'));
    })
</script>

<style lang="scss">
    @import './assets/sass/main.scss';
</style>
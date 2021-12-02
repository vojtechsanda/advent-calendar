<template>
    <form @submit="showAdventCalendar" class="home">
        <h1 class="home__heading">Enter your advent key</h1>
        <input type="text" class="home__input" placeholder="Advent key" v-model="adventKey">
        <button class="home__btn" @click="showAdventCalendar">Show</button>
    </form>
</template>
<script>
    export default {
        data() {
            return {
                adventKey: ''
            }
        },
        methods: {
            showAdventCalendar() {
                this.$router.push(this.adventKey.toLowerCase())
            }
        }
    }
</script>
<template>
    <Loading v-if="!isLoaded"></Loading>
    <h1 class="dashes__heading">Adventní kalendář</h1>
    <div class="dashes">
        <Dash
            v-for="(num, i) in numbers"
            :key="i"
            :num="num"
            :col="i % 4"
            :cols="4"
            :row="Math.floor(i / 4)"
            :rows="6"
            :img-width="2160"
            :img-height="2880"
            :img-url="adventImgUrl"
            :should-be-opened="shouldOpenDay[i]"
            @opened="updatedOpened"
        ></Dash>
        <img src="/assets/imgs/hat.png" class="dashes__hat" @click="openWebsite">
    </div>
    <img :src="adventImgUrl" style="display: none">
</template>

<script>
    import Dash from '../components/Dash.vue'
    import Loading from '../components/Loading.vue'
    import axios from 'axios'

    export default {
        components: { Dash, Loading },
        props: [ 'advent_key' ],
        data() {
            return {
                adventImgUrl: `/assets/imgs/advents/${this.advent_key.toLowerCase()}.jpg`,
                isLoaded: false,
                numbers: [
                    1,
                    8,
                    6,
                    2,
                    9,
                    13,
                    16,
                    11,
                    12,
                    15,
                    22,
                    5,
                    14,
                    24,
                    23,
                    17,
                    3,
                    21,
                    19,
                    4,
                    10,
                    20,
                    18,
                    7
                ],
                shouldOpenDay: [false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false]
            }
        },
        mounted() {
            this.loadCalendar()
        },
        methods: {
            async loadCalendar() {
                const startTime = new Date().getTime();
                const resp = await axios(`https://api.vojtechsanda.cz/advent/?advent-key=${this.advent_key}&t=${startTime}`);
                const endTime = new Date().getTime();

                if (resp.data == null) {
                    this.$router.push('/')
                    return;
                }

                const days = JSON.parse(JSON.parse(resp.data.days));
                this.shouldOpenDay = days;

                if (endTime - startTime < 1500) {
                    setTimeout(() => {
                        this.isLoaded = true;
                    }, 1500 - (endTime - startTime))
                } else {
                    this.isLoaded = true;
                }

            },
            updatedOpened(openedNum) {
                const time = new Date().getTime();
                const index = this.numbers.indexOf(openedNum);
                this.shouldOpenDay[index] = true;
                const days = JSON.stringify(this.shouldOpenDay);

                axios(`https://api.vojtechsanda.cz/advent/?advent-key=${this.advent_key}&days=${days}&t=${time}`);
            },
            openWebsite() {
                window.open('https://vojtechsanda.cz', '_blank')
            }
        }
    };
</script>
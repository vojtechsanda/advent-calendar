<template>
    <div
        class="dash"
        :class="{ 'dash--can-be-opened': canBeOpened, 'dash--is-opened': isOpened }"
        :style="
            {
                'background': background,
                'background-position': backgroundPos,
                'background-repeat': 'no-repeat',
                'background-size': backgroundSize
            }
        "
        @click="open"
    >
    <span class="dash__text">{{ num }}</span>
    </div>
</template>

<script>
    export default {
        props: ['col', 'cols', 'row', 'rows', 'imgWidth', 'imgHeight', 'imgUrl', 'shouldBeOpened', 'num'],
        data() {
            return {
                isOpened: this.shouldBeOpened,
                backgroundSize: ''
            }
        },
        computed: {
            background() {
                if (this.isOpened) {
                    return `url(${this.imgUrl})`;
                }

                return '#BB2528'
            },
            backgroundPos() {
                return `${this.col * (100 / (this.cols - 1))}% ${this.row * (100 / (this.rows - 1))}%`;
            },
            canBeOpened() {
                const d = new Date();
                const day = d.getDate()
                return this.num <= day && d.getMonth() == 11
            }
        },
        mounted() {
            this.setBackgroundSize();
            this.$nextTick(() => {
                window.addEventListener('resize', this.setBackgroundSize);
            })
        },
        beforeUnmount() { 
            window.removeEventListener('resize', this.setBackgroundSize); 
        },
        methods: {
            open() {
                if (this.canBeOpened) {
                    this.isOpened = true
                    this.$emit('opened', this.num)
                }
            },
            setBackgroundSize() {
                let mult = 0.8;

                if (window.innerWidth <= 970) {
                    mult *= 0.75;
                }
                if (window.innerWidth <= 768) {
                    mult *= 2 / 3;
                }
                if (window.innerWidth <= 530) {
                    mult *= 0.75;
                }
                if (window.innerWidth <= 400) {
                    mult *= 0.8;
                }

                this.backgroundSize = `${this.imgWidth * mult / 2}px ${this.imgHeight * mult / 2}px`;
            }
        },
        watch: {
            shouldBeOpened(newVal) {
                if (newVal && this.canBeOpened) {
                    this.isOpened = true
                }
            }
        }
    };
</script>
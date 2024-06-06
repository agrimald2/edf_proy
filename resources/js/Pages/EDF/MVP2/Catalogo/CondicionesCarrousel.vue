<template>
    <div class="relative slide">
        <div class="carousel-inner relative overflow-hidden w-full">
            <div v-for="(img, i) in images" :id="`slide-${i}`" :key="i"
                :class="`${active === i ? 'active' : 'left-full'}`"
                class="carousel-item inset-0 relative w-full transform transition-all duration-500 ease-in-out">
                <img class="block w-full" :src="img" alt="Slide image" />
            </div>
        </div>
        <div class="w-100 mt-2">
            <div class="carousel-indicators bottom-0 flex h-10 w-full justify-center items-center md:flex">
                <ol class="z-50 flex w-4/12 justify-center">
                    <li v-for="(img, i) in images" :key="i"
                        :class="`w-3 h-3 md:w-6 md:h-6 rounded-full cursor-pointer mx-2 ${active === i ? 'bg-red-500 scale-125' : 'bg-gray-300'}`"
                        @click="setActive(i)"></li>
                </ol>
            </div>
        </div>
    </div>
</template>
<style>
.left-full {
    left: -100%;
}

.carousel-item {
    float: left;
    position: relative;
    display: block;
    width: 100%;
    margin-right: -100%;
    backface-visibility: hidden;
}

.carousel-item.active {
    left: 0;
}
</style>
<script>
export default {
    data() {
        return {
            images: [
                "/images/condiciones_1.png",
                "/images/condiciones_2.png"
            ],
            active: 0
        };
    },
    methods: {
        setActive(index) {
            this.active = index;
        }
    },
    mounted() {
        let i = 0;
        setInterval(() => {
            if (i > this.images.length - 1) {
                i = 0;
            }
            this.active = i;
            i++;
        }, 10000);
    }
};
</script>

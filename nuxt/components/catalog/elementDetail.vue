<script setup lang="ts">
    const route = useRoute()
    const { data: element } = await useFetch(`/api/posts/catalog-element/${route.params.section_code}/${route.params.element_code}`)
</script>

<template>
    <div class="wrapper">
        <div class="container">
            <div class="catalog-item-detail">
                <div class="main-info-container">
                    <div class="img-block">
                        <div class="main-img-container">
                            <img :src="element.DETAIL_PICTURE.SRC" alt="">
                        </div>
                    </div>
                    <div class="info-block">
                        <h1>{{ element.NAME }}</h1>
                        <div class="detail-text">{{ element.DETAIL_TEXT }}</div>
        
                        <div class="price-block">
                            <div class="price">700 руб. за м.п.</div>
                            <button class="btn">Заказать расчет</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.layout {
    @import '~/assets/scss/layouts/catalog/elementDetail.scss';
}
</style>
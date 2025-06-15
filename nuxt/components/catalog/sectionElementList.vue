<script setup lang="ts">
    const route = useRoute()
    const { data: elements } = await useFetch(`/api/posts/catalog-elements/${route.params.section_code}`)
</script>

<template>
    <div class="catalog-container">
        <div class="catalog-filter"></div>

        <div class="catalog-items">
            <div class="catalog-items-item" v-if="elements.length > 0" v-for="(item, key) in elements">
                <div class="label-row">
                    <div class="label">Акция</div>
                </div>

                <div class="img-container">
                    <img :src="item.PREVIEW_PICTURE.SRC">
                </div>

                <div class="info-container">
                    <div class="info">
                        <div class="name">{{item.NAME}}</div>
                        <div class="text">{{item.PREVIEW_TEXT}}</div>
                    </div>
                    <div class="button-container">
                        <div class="price">4 100 руб.</div>
                        <NuxtLink :to="item.DETAIL_PAGE_URL" class="btn-detail">Подробнее</NuxtLink>
                        <!-- <a :href="item.DETAIL_PAGE_URL" class="btn-detail">Подробнее</a> -->
                    </div>
                    
                </div>
            </div>
            <div class="empty" v-else>Нет товаров</div>
        </div>
    </div>
    <!-- <pre>{{ elements }}</pre> -->
</template>

<style lang="scss">
.layout {
    @import '~/assets/scss/layouts/catalog/sectionElementList.scss';
}
</style>
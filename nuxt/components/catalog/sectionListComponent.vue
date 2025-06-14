<script setup lang="ts">
    const { data: posts } = await useFetch('/api/posts/catalog-sections')
</script>

<template>
    <div class="section-list">
        <a :href="section.SECTION_PAGE_URL" class="section-item" v-for="(section, key) in posts.result">
            <div class="section-item-name">
                {{ section.NAME }}
            </div>
            <div class="section-item-image">
                <img :src="section.PICTURE.SRC" alt="">
            </div>
        </a>
    </div>
</template>

<style lang="scss">
.layout {
    @import '~/assets/scss/layouts/catalog/sectionList.scss';
}
</style>
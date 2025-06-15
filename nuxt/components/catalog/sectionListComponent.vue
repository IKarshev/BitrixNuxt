<script setup lang="ts">
    const { data: posts } = await useFetch('/api/posts/catalog-sections')
</script>

<template>
    <div class="section-list">
        <NuxtLink :to="section.SECTION_PAGE_URL" class="section-item" v-for="(section, key) in posts">
        <!-- <a :href="section.SECTION_PAGE_URL" class="section-item" v-for="(section, key) in posts"> -->
            <div class="section-item-name">
                {{ section.NAME }}
            </div>
            <div class="section-item-image">
                <img :src="section.PICTURE.SRC" alt="">
            </div>
        <!-- </a> -->
        </NuxtLink>
    </div>
</template>

<style lang="scss">
.layout {
    @import '~/assets/scss/layouts/catalog/sectionList.scss';
}
</style>
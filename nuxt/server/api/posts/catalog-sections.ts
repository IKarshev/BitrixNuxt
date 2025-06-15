import {getPostCatalogSectionUrl} from '@/data/posts'

export default defineEventHandler(async (event) => {
    const data = await $fetch(getPostCatalogSectionUrl());
    return data.result;
})
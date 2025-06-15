import { getPostCatalogElementsUrl } from '@/data/posts'

export default defineEventHandler(async (event) => {
    const data = await $fetch(getPostCatalogElementsUrl());
    return data.result;
})
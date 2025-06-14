import { getPostCatalogElementsUrl } from '@/data/posts'

export default defineEventHandler(async (event) => {
    const { section_code } = getRouterParams(event)
    const data = await $fetch(getPostCatalogElementsUrl() + `?section_code=${section_code}`);
    return data;
})
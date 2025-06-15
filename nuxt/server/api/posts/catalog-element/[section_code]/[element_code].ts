import { geElementDetailUrl } from '@/data/posts'

export default defineEventHandler(async (event) => {
    const { section_code, element_code } = getRouterParams(event)
    const data = await $fetch(geElementDetailUrl() + `?section_code=${section_code}&element_code=${element_code}`);
    return data.result;
})
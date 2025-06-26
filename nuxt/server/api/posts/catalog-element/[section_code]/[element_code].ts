import { getApiUrl } from '~/server/utils/api'

export default defineEventHandler(async (event) => {
    const { section_code, element_code } = getRouterParams(event)
    const url = getApiUrl(`getElementDetail/?section_code=${section_code}&element_code=${element_code}`)
    const data = await $fetch(url);
    return data.result;
})
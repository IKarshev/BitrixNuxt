import { getApiUrl } from '~/server/utils/api'

export default defineEventHandler(async (event) => {
    const { section_code } = getRouterParams(event)
    const url = getApiUrl(`getElements/?section_code=${section_code}`)
    const data = await $fetch(url);
    return data.result;
}) 
import { getApiUrl } from '~/server/utils/api'

export default defineEventHandler(async (event) => {
    const url = getApiUrl('getElements')
    const data = await $fetch(url);
    return data.result;
})
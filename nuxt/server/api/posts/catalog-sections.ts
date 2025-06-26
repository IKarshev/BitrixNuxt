import { getApiUrl } from '~/server/utils/api'

export default defineEventHandler(async (event) => {
  const url = getApiUrl('getCatalogSectionList')
  const data = await $fetch(url)
  return data.result
})
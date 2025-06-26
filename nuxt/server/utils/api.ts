export const getApiUrl = (endpoint: string) => {
  const runtimeConfig = useRuntimeConfig()
  return `${runtimeConfig.apiUrl}${runtimeConfig.apiToken}/${endpoint}`
}
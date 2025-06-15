<template>
    <ul v-if="breadcrumbs" class="breadcrumb-list">
        <li v-for="(item, key) in breadcrumbs">
            <template v-if="key+1 < breadcrumbs.length">
                <NuxtLink :to="item.LINK">{{ item.TEXT }}</NuxtLink>
                <span class="separator">/</span>
            </template>
            <template v-else>
                <span>{{ item.TEXT }}</span>
            </template>
        </li>
    </ul>
</template>
<script>
    export default {
        props: {
            breadcrumbs: {
                default: () => {
                    return [
                        {
                            TEXT: 'Главная',
                            LINK: '/',
                        }
                    ]
                },
                type: Array, // String, Array, Object, Number etc.
            }
        }
    }
</script>

<style lang="scss">
.layout {
    @import '~/assets/scss/BreadCrumbsComponent.scss';
}
</style>
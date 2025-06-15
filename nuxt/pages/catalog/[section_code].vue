<script setup lang="ts">
    import BreadCrumbsComponent from '@/components/BreadCrumbsComponent.vue';
    import sectionElementList from "@/components/catalog/sectionElementList.vue";

    const breadcrumbList = [
        {
            'TEXT': 'Главная',
            'LINK': '/',
        },
        {
            'TEXT': 'Каталог',
            'LINK': '/catalog/',
        },
    ]
</script>

<template>
    <div class="wrapper">
        <div class="container">
            <BreadCrumbsComponent :breadcrumbs="breadcrumbList"></BreadCrumbsComponent>
            <sectionElementList></sectionElementList>
        </div>
    </div>
</template>
<script setup>
    import BreadCrumbsComponent from '@/components/BreadCrumbsComponent.vue';
    import sectionListComponent from "@/components/catalog/sectionListComponent.vue";

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
            <h1>Разделы</h1>
            <sectionListComponent></sectionListComponent>
        </div>
    </div>
</template>
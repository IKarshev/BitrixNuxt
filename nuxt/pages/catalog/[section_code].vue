<script setup lang="ts">
    const route = useRoute()
</script>
<template>
    <pre>
        {{ route.params.section_code }}
    </pre>
</template>
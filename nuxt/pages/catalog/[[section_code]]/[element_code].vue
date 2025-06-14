<script setup lang="ts">
    const route = useRoute()
</script>
<template>
    <pre>
        {{ route.params.section_code }} </br>
        {{ route.params.element_code }}
    </pre>
</template>
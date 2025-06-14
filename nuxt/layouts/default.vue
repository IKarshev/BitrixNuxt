<script setup>
  import HeaderComponent from "@/components/HeaderComponent.vue";
  import FooterComponent from "@/components/FooterComponent.vue";
</script>

<template>
  <div class="layout">
    <HeaderComponent />
    <main class="main" id="main">
      <slot></slot>
    </main>
    <FooterComponent />
  </div>
</template>
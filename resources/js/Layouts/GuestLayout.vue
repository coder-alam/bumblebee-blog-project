<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <div class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
      </div>
      <slot />
    </div>
  </div>
</template>

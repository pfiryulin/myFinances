<script setup>
import {computed, ref, reactive} from 'vue';

const footerItems = ref(
    [
              'Контакты',
               'Социальные сети',
               'LOGOTIP',
               'New ITEM',
          ]
)
</script>

<template>
<!--  {{ item.title }}-->
  <div v-for="item in footerItems" class="footer__item">{{ item }}</div>
<!--  {{ footerItems }}-->
</template>

<style scoped>

</style>
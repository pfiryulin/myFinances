<script setup>
    function getHref(e){
        console.log(e.target.href)
    }
</script>

<template>
  <header>
    <div class="header-logo">myFinances</div>
    <div class="header-menu">
      <ul class="menu-items">
        <li class="menu-item">
          <a href="/operations/" @click.prevent="getHref">Операции</a>
        </li>
        <li class="menu-item">
          <a href="/categories/" @click.prevent="getHref">Категории</a>
        </li>
        <li class="menu-item">
          <a href="/reports/" @click.prevent="getHref">Отчеты</a>
        </li>
      </ul>
    </div>
  </header>
</template>

<style scoped>

</style>

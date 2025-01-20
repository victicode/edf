<template>
  <main  class="h-screen md:py-2">
    <RouterView class="appMobile "/>
  </main>
</template>
<style>
.appMobile{
  width: 60%;
  overflow: hidden;
  margin: auto;
  border-radius: 20px;
}
@media (max-width: 780px) {
  .appMobile{
    width: 100%;
    border-radius: 0px;

  }
}

</style>
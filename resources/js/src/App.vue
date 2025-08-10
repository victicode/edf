<template>
  <main  class="h-screen ">
    <RouterView class="appMobile "/>
  </main>
</template>
<style>
.appMobile{
  width: 100%;
  overflow: hidden;
  margin: auto;
}
@media (max-width: 780px) {
  .appMobile{
    width: 100%;
    border-radius: 0px;

  }
}

</style>
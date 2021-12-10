<template>
  <div class="overflow-y-auto h-screen xl:h-screen bg-tosca-800" scroll-region>
    <div class="bg-tosca-800 p-6">
      <div class="bg-white font-sans rounded-md bg-cover xl:w-full" :style="(pageName==='Home/Index')?'background-image:url(\'/img/bg2.svg\');':''">
        <div class="container mx-auto lg:px-8 px-6 py-5">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Layout',
  data(){
    return{
      pageName:'',
    }
  },
  mounted() {
    this.pageName = this.$inertia.page.component
    // console.log(this.$inertia.page.component)
  },
}
</script>
<style scoped>

</style>

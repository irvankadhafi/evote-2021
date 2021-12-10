<template>
  <Transition name="fade">
    <div
      v-if="showing"
      class="fixed inset-0 w-full h-screen flex items-center justify-center z-100"
      style="background: rgba(0,0,0,.9);" @click="$emit('close')"
    >
      <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8 slide-in-bottom-modal mx-4 my-2" @click.stop>
        <button
          aria-label="close"
          class="absolute top-0 right-0 text-3xl text-gray-500 my-2 mx-4"
          @click.prevent="close"
        >
          ×
        </button>
        <slot />
      </div>
    </div>
  </Transition>
</template>

<script>
export default {
  name: 'CardModal',
  props: {
    showing: {
      required: true,
      type: Boolean,
    },
  },
  watch: {
    showing(value) {
      if (value) {
        return document.querySelector('body').classList.add('overflow-hidden')
      }

      document.querySelector('body').classList.remove('overflow-hidden')
    },
  },
  methods: {
    close() {
      this.$emit('close')
    }
  },
}
</script>

<!--<style scoped>-->
<!--.fade-enter-active,-->
<!--.fade-leave-active {-->
<!--    transition: all 0.3s;-->
<!--}-->
<!--.fade-enter,-->
<!--.fade-leave-to {-->
<!--    opacity: 0;-->
<!--}-->
<!--</style>-->

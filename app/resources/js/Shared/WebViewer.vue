<template>
  <div ref="viewer" />
</template>

<script>
import WebViewer from '@pdftron/webviewer'
export default {
  name: 'WebViewer',
  props: {
    url: String,
  },
  data(){
    return{
      path:'/lib',
    }
  },
  mounted: function () {
    WebViewer({
      path: this.path,
      initialDoc: this.url, // replace with your own PDF file
    }, this.$refs.viewer).then(instance => {
      const { docViewer } = instance

      docViewer.setWatermark({
        // Draw diagonal watermark in middle of the document
        diagonal: {
          fontSize: 25, // or even smaller size
          fontFamily: 'sans-serif',
          color: 'red',
          opacity: 50, // from 0 to 100
          text: 'Watermark',
        },

        // Draw header watermark
        header: {
          fontSize: 10,
          fontFamily: 'sans-serif',
          color: 'red',
          opacity: 70,
          left: 'left watermark',
          center: 'center watermark',
          right: '',
        },
      })
    })
  },
}
</script>

<style scoped>
div {
    width: 100%;
    height: 100vh;
}
</style>

<template>
  <div class="h-screen overflow-y-auto bg-tosca-800 p-8" scroll-region>
    <div class="md:w-1/2 m-auto bg-white rounded-md p-8 mb-8">
      <header class="items-center justify-between relative">
        <a :href="mahasiswa.status_kls===0 ? route('voting.profil') : (prevPage==='visimisi.kandidat' ? route('voting.kandidat'): route(prevPage) ) " class="btn-indigo right-0 md:text-center text-white rounded-full absolute text-xl">
          Kembali
        </a>
        <img src="/img/hmjtk-logo.png" class="w-32 m-auto">
        <h3 class="text-center text-4xl text-gray-900 font-medium leading-8">PEMILU HMJTK POLBAN 2021</h3>
        <div class="text-center text-gray-600 text-xl font-semibold pt-4">
          <p>Dokumen Lain Kandidat <strong>{{ kandidat.name }}</strong></p>
        </div>
        <!--        </inertia-link>-->
      </header>
    </div>
    <div class="md:w-1/2 m-auto h-screen bg-white rounded-md p-8">
      <pdf-app :pdf="kandidat.pdf_visimisi" />
    </div>
  </div>
</template>
<script>
import PdfApp from 'vue-pdf-app'
export default {
  name: 'VisiMisi',
  components: {
    PdfApp,
  },
  props: {
    kandidat: Object,
    mahasiswa:Object,
    errors: Object,
    flash: Object,
    prevPage:String,
  },
  data(){
    return{
      // resume: '/dokumen/CV_Cecep.pdf',
    }
  },
  mounted() {
    // console.log(this.kandidat[0])
    // console.log(this.prevPage)
  },
}
</script>

<style scoped>

</style>

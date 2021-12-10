<template>
  <Layout>
    <header class="items-center justify-between relative">
      <inertia-link as="button" class="btn-red right-0 md:text-center text-white rounded-full absolute" :href="route('voting.logout')">Log Out</inertia-link>
      <img src="/img/hmjtk-logo.png" class="w-32 m-auto">
      <h3 class="text-center text-4xl text-gray-900 font-medium leading-8">PEMIRA HMJTK POLBAN 2021</h3>
      <div class="text-center text-gray-600 text-xs font-semibold pt-2">
        <p>Pemilihan Ketua HMJTK POLBAN Periode 2021</p>
      </div>
    </header>
    <hr class="mb-6 mt-6 border-t">
    <div class="xl:flex xl:items-center xl:justify-center xl:mt-8 xl:mb-5">
      <div v-for="data in kandidat" class="container xl:mx-10 max-w-xs overflow-hidden rounded-lg shadow-2xl bg-white my-5">
        <div class="relative text-center text-white">
          <!--800x800-->
          <img :src="data.foto" class="w-full">
          <div class="absolute w-full" style="bottom:-2rem">
            <div class="mb-5">
              <p class="text-xl font-bold tracking-wide text-white" style="text-shadow: 2px 2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000, -2px -2px 0 #000, 2px 0px 0 #000, 0px 2px 0 #000, -2px 0px 0 #4074b5, 0px -2px 0 #000;">{{ data.name }}</p>
            </div>
            <button class="w-12 h-12 rounded-full transition ease-in duration-200 focus:outline-none bg-red-600 text-white" @click="toggleModalKonfirmasi(data.id)">
              <i class="fas fa-vote-yea fa-lg" />
            </button>
          </div>
        </div>
        <div class="px-4 pt-12 pb-4  flex items-center text-center leading-none text-gray-800">
          <button class="btn-green m-auto" @click="toggleModalVisiMisi(data.id)">Visi & Misi</button>
          <inertia-link class="btn-indigo float-right m-auto" as="button" :href="'/kandidat/resume/'+data.id">Dokumen CV</inertia-link>
        </div>
      </div>
    </div>
    <div class="mt-8 mb-5 flex flex-wrap">
      <inertia-link as="button" class="md:w-1/3 btn-green m-auto" :href="route('voting.info')">Back</inertia-link>
    </div>

    <!--Modal Visi Misi-->
    <card-modal :showing="visimisiModal" @close="visimisiModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Visi Misi</h2>
      <div v-if="idKandidat" class="pb-6 pt-3">
        <p class="pt-3 text-base font-medium text-gray-900">Visi</p>
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide" v-html="kandidat.find(calon => calon.id === idKandidat).visi" />
        <p class="pt-3 text-base font-medium text-gray-900">Misi</p>
        <p class="pt-3 text-sm text-gray-80 leading-5 tracking-wide" v-html="kandidat.find(calon => calon.id === idKandidat).misi" />
      </div>
      <div v-else class="pb-6 pt-3">
        <p class="pt-3 text-base font-medium text-gray-900">Tidak Ada Data</p>
      </div>
      <button class="btn-red float-right" @click="visimisiModal = false">Close</button>
      <inertia-link class="btn-indigo float-right mx-5" as="button" :href="route('visimisi.kandidat',idKandidat)">Dokumen Lain</inertia-link>
    </card-modal>

    <!--Modal Konfirmasi Pilih-->
    <card-modal :showing="konfirmasiModal" @close="konfirmasiModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Verifikasi</h2>
      <div class="pb-6 pt-3">
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide">
          Saya memilih Calon Ketua Himpunan nomor urut ke {{ idKandidat }}. Dengan kondisi :
        </p>
        <ul class="list-none list-disc text-sm text-gray-800 leading-5 pl-5">
          <li>Sadar dan mengerti atas pilihan saya.</li>
          <li>Tanpa paksaan atau intervensi dari siapapun.</li>
          <li>Sesuai dengan keinginan saya.</li>
        </ul>
      </div>
      <button class="btn-red float-right mx-2" @click="konfirmasiModal = false">Tidak</button>
      <div v-if="mahasiswa.status_mhs===0 && mahasiswa.status_kls===0">
        <button class="btn-green float-right mx-2" @click="toggleModalBelumBoleh">Ya</button>
      </div>
      <div v-else>
        <form class="float-right mx-2" @submit.prevent="pilih(mahasiswa.nim,idKandidat)">
          <loading-button :loading="sending" class="btn-green" type="submit">Ya</loading-button>
        </form>
      </div>
    </card-modal>

    <!--Modal Berhasil Voting-->
    <card-modal :showing="successVotingModal" @close="successVotingModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Hi {{ mahasiswa.name }}</h2>
      <div class="pb-6 pt-3">
        <p v-if="$page.props.flash.success" class="pt-3 text-sm text-gray-800 leading-5 tracking-wide font-bold">
          {{ $page.props.flash.success }}
        </p>
        <p v-else-if="$page.props.flash.error" class="pt-3 text-sm text-gray-800 leading-5 tracking-wide font-bold">
          {{ $page.props.flash.error }}
        </p>
      </div>
      <button class="btn-red float-right" @click="successVotingModal = false">Close</button>
    </card-modal>

    <!--Modal Belum Boleh Milih-->
    <card-modal :showing="belumMilihModal" @close="belumMilihModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Alert!!!</h2>
      <div class="pb-6 pt-3">
        <p v-if="$page.props.flash.success" class="pt-3 text-sm text-gray-800 leading-5 tracking-wide">
          {{ $page.props.flash.success }}
        </p>
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide">
          Kamu belum diizinkan untuk memilih. Silahkan hubungi panitia
        </p>
      </div>
      <button class="btn-red float-right" @click="belumMilihModal = false">Close</button>
    </card-modal>
  </Layout>
</template>

<script>
import LoadingButton from '../../Shared/LoadingButton'
import CardModal from '../../Shared/CardModal'
import Layout from './Layout'
export default {
  name: 'Kandidat',
  components: {
    Layout,
    LoadingButton,
    CardModal,
  },
  props: {
    kandidat: Array,
    mahasiswa: Object,
    errors: Object,
    flash: Object,
  },
  data(){
    return{
      sending: false,
      visimisiModal : false,
      konfirmasiModal : false,
      belumMilihModal : false,
      successVotingModal:false,
      errorModal:false,
      idKandidat:0,
    }
  },
  mounted() {
    let self = this
    window.addEventListener('keyup', function(event) {
      // If  ESC key was pressed...
      if (event.keyCode === 27) {
        // try close your modal
        // self.welcomeModal = false
      }
    })
  },
  methods:{
    toggleModalVisiMisi(paramIndex){
      this.idKandidat = paramIndex
      this.visimisiModal = !this.visimisiModal
    },
    toggleModalKonfirmasi(paramIndex){
      this.idKandidat = paramIndex
      this.konfirmasiModal = !this.konfirmasiModal
    },
    toggleModalBelumBoleh(){
      this.konfirmasiModal = false
      this.belumMilihModal = !this.belumMilihModal
    },
    goBack(){
      window.setTimeout(function() {
        window.location.href = this.route('voting.logout')
      }, 2000)
    },
    pilih(nim, kandidat){
      const data = new FormData()
      data.append('nim', nim || '')
      data.append('kandidat_id', kandidat || '')

      this.$inertia.post(this.route('voting.pilih'), data, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false,this.konfirmasiModal=false,this.successVotingModal=true,this.goBack()),
      })
    },
  },
}
</script>

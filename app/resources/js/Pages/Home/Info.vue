<template>
  <Layout>
    <header class="items-center justify-between relative">
      <inertia-link as="button" class="btn-red right-0 md:text-center text-white rounded-full absolute" :href="route('voting.logout')">Log Out</inertia-link>
      <img src="/img/hmjtk-logo.png" class="w-32 m-auto">
      <h3 class="text-center text-4xl text-gray-900 font-medium leading-8">PEMIRA HMJTK POLBAN 2021</h3>
      <div class="text-center text-gray-600 text-xs font-semibold pt-2">
        <p>Pemilihan Ketua HMJTK POLBAN</p>
      </div>
    </header>
    <hr class="mb-6 mt-6 border-t">
    <h2 class="text-center text-2xl text-gray-900 font-medium leading-8 pb-5">Selamat datang di PEMIRA HMJTK POLBAN 2021</h2>
    <div class="md:w-1/3 m-auto mb-3">
      <div class="bg-gray-50 shadow-md rounded-lg py-3 hover:bg-gray-100 transition delay-75 duration-300 ease-in-out">
        <div class="p-2">
          <h3 class="text-center md:text-xl text-gray-900 font-medium leading-8">{{ mahasiswa.name }}</h3>
          <div class="text-center text-gray-600 md:text-xs font-semibold">
            <p>{{ mahasiswa.nim }}</p>
          </div>
          <table class="text-xs my-3">
            <tbody>
              <tr>
                <td class="px-2 py-2 text-gray-600 font-semibold">Jurusan</td>
                <td class="px-2 py-2">Jurusan Teknik Kimia</td>
              </tr>
              <tr>
                <td class="px-2 py-2 text-gray-600 font-semibold">Prodi</td>
                <td class="px-2 py-2">{{ mahasiswa.prodi }}</td>
              </tr>
              <tr>
                <td class="px-2 py-2 text-gray-600 font-semibold">Kelas</td>
                <td class="px-2 py-2">{{ mahasiswa.kelas }}</td>
              </tr>
            </tbody>
          </table>
          <div class="text-center my-3">
            <div v-if="mahasiswa.status_mhs===0">
              <span class="inline-flex items-center justify-center px-4 py-2 font-bold leading-none text-white bg-red-600 rounded-full text-xl">Belum Memilih</span>
            </div>
            <div v-else>
              <span class="inline-flex items-center justify-center px-4 py-2 font-bold leading-none text-white bg-green-600 rounded-full text-xl">Sudah Memilih</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="mahasiswa.status_kls===0" class="mt-5 mb-5 flex flex-wrap">
      <button class="md:w-1/3 btn-red m-auto" @click="toggleMulai">Mulai Memilih</button>
    </div>
    <div v-else class="mt-5 mb-5 flex flex-wrap">
      <button v-if="mahasiswa.status_mhs===1" class="md:w-1/3 btn-red m-auto" @click="toggleSudahMilih">Sudah Memilih</button>
      <inertia-link v-else as="button" class="md:w-1/3 btn-green m-auto" :href="route('voting.kandidat')">Mulai Memilih</inertia-link>
    </div>
    <div class="mt-5 mb-5 flex flex-wrap">
      <inertia-link as="button" class="md:w-1/3 btn-green m-auto" :href="route('voting.profil')">Profil Calon</inertia-link>
    </div>

    <!--Modal Welcome-->
    <card-modal :showing="welcomeModal" @close="welcomeModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Selamat Datang {{ mahasiswa.name }}</h2>
      <div class="pb-6 pt-3">
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide font-bold">
          Berikut tata cara pemilihan :
        </p>
        <ul class="list-none list-disc text-sm text-gray-800 leading-5 pl-5">
          <li>
            Tombol menu untuk memilih tidak akan muncul sampai pihak dari panitia mengizinkan kelas anda untuk memilih.
          </li>
          <li>
            Sambil menunggu pihak panitia mengizinkan anda untuk memilih, silahkan untuk mengenali calon lebih dekat dengan memilih menu profil.
          </li>
          <li>
            Ketika pihak panitia sudah mengizinkan kelas anda untuk memilih, silahkan lakukan pemilihan dengan memilih menu mulai memilih
          </li>
          <li>
            Suara anda sangat berpengaruh besar untuk himpunan kedepannya.
          </li>
        </ul>
      </div>
      <button class="btn-red float-right" @click="welcomeModal = false">Close</button>
    </card-modal>

    <!--Modal Belum Boleh Milih-->
    <card-modal :showing="belumMilihModal" @close="belumMilihModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Alert!!!</h2>
      <div class="pb-6 pt-3">
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide">
          Kelas kamu belum diizinkan untuk memilih.
        </p>
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide">
          Kamu bisa melihat profil calon dahulu.
        </p>
      </div>
      <button class="btn-red float-right" @click="belumMilihModal = false">Close</button>
    </card-modal>

    <!--Modal Sudah Milih-->
    <card-modal :showing="sudahMilihModal" @close="sudahMilihModal = false">
      <h2 class="text-xl font-bold text-gray-900 border-b-2 pb-3">Alert!!!</h2>
      <div class="pb-6 pt-3">
        <p class="pt-3 text-sm text-gray-800 leading-5 tracking-wide">
          Kamu sudah memilih, pemilih hanya sekali diperkenankan untuk memilih.
        </p>
      </div>
      <button class="btn-red float-right" @click="sudahMilihModal = false">Close</button>
    </card-modal>
  </Layout>
</template>

<script>
import CardModal from '../../Shared/CardModal'
import Layout from './Layout'
export default {
  name: 'Info',
  components: {
    Layout,
    CardModal,
  },
  props: {
    mahasiswa: Object,
    errors: Object,
    flash: Object,
  },
  data(){
    return{
      sending: false,
      welcomeModal:true,
      belumMilihModal:false,
      sudahMilihModal:false,
    }
  },
  mounted() {
    let self = this
    window.addEventListener('keyup', function(event) {
      // If  ESC key was pressed...
      if (event.keyCode === 27) {
        // try close your modal
        self.welcomeModal = false
      }
    })
  },
  methods:{
    toggleMulai(){
      this.belumMilihModal = !this.belumMilihModal
    },
    toggleSudahMilih(){
      this.sudahMilihModal = !this.sudahMilihModal
    },
  },
}
</script>

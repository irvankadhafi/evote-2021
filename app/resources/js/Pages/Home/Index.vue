<template>
  <div class="overflow-y-auto" scroll-region>
    <div class="h-screen pb-14 bg-right bg-cover " style="background-image:url('/img/bg2.svg');">
      <!--Nav-->
      <div class="w-full container mx-auto p-6">
        <div class="w-full flex items-center justify-between">
          <a class="flex items-center md:text-tosca-800 no-underline hover:no-underline font-bold text-2xl lg:text-4xl">
            <img class="w-12 mr-4" src="/img/hmjtk-logo.png"> HMJTK E-VOTE
          </a>
        </div>
      </div>

      <!--Main-->
      <div class="container px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!--Left Col-->
        <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
          <h1 class="my-4 text-3xl md:text-5xl md:text-tosca-800 sm:text-white font-bold leading-tight text-center md:text-left slide-in-bottom-h1">Selamat Datang di E-Voting HMJTK</h1>
          <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left slide-in-bottom-subtitle">Aplikasi E-Voting ini dibuat untuk memudahkan dalam pengambilan suara pemilihan calon ketua HMJTK.</p>

          <button class="btn-tosca slide-in-bottom md:w-1/3 md:text-center text-lg font-bold text-white rounded-full sm:my-3" type="button" @click="toggleModal()">
            <span>Voting!</span>
          </button>
        </div>

        <!--Right Col-->
        <div class="w-full xl:w-3/5 py-6 overflow-y-hidden">
          <img class="w-5/6 mx-auto lg:mr-0 slide-in-bottom" src="/img/voting.svg">
        </div>
        <!--Footer-->
        <div class="w-full  pb-6 text-sm text-center md:text-left fade-in">
          <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; HMJTK 2020</a>
        </div>
      </div>
      <!--Login Modal-->
      <card-modal :showing="showModal" @close="showModal = false">
        <h2 class="text-xl font-bold text-gray-900">Login</h2>
        <transition name="fade">
          <p v-if="$page.props.flash.error" class="font-bold pt-3 text-red-600 text-right">{{ $page.props.flash.error }}</p>
        </transition>
        <form @submit.prevent="loginMahasiswa()">
          <text-input v-model="form.nim" :error="errors.nim" type="text" class="pt-4" label="NIM" placeholder="NIM" />
          <text-input v-model="form.token" :error="errors.token" class="pt-4 pb-4" type="password" label="Token" placeholder="******" />
          <loading-button :loading="sending" class="btn-tosca float-right" type="submit">Login</loading-button>
        </form>
        <button
          class="btn-red"
          @click="showModal = false"
        >
          Close
        </button>
        <ul class="list-none list-disc text-sm text-gray-800 leading-5 pt-5 pl-6">
          <li>Username adalah NIM Mahasiswa</li>
          <li>password dapat didapatkan dari panitia PEMIRA atau perwakilan kelas masing-masing</li>
          <li>Jika mengalami permasalahan login dapat melapor kepada panitia PEMIRA</li>
        </ul>
      </card-modal>
    </div>
  </div>
</template>

<script>
import LoadingButton from '../../Shared/LoadingButton'
import CardModal from '../../Shared/CardModal'
import TextInput from '../../Shared/TextInput'
import Layout from './Layout'
export default {
  name: 'Index',
  metaInfo: { title: 'Home' },
  components: {
    LoadingButton,
    CardModal,
    TextInput,
    Layout,
  },
  props: {
    errors: Object,
    statusLogin:String,
  },
  data() {
    return {
      sending: false,
      showModal: false,
      form: {
        nim: null,
        token: null,
      },
    }
  },
  methods: {
    toggleModal() {
      this.showModal = !this.showModal
    },
    loginMahasiswa() {
      const data = new FormData()
      data.append('nim', this.form.nim || '')
      data.append('token', this.form.token || '')
      this.$inertia.post(this.route('voting.login'), data,{
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>

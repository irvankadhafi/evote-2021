<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Mahasiswa</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Kelas:</label>
        <select v-model="form.kelas" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option v-for="data in dataKelas" :value="data.name">{{ data.name }}</option>
        </select>
        <label class="block text-gray-700 pt-3">Prodi:</label>
        <select v-model="form.prodi" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option value="24301">D4-Teknik Kimia Produksi Bersih</option>
          <option value="24401">D3-Teknik Kimia</option>
          <option value="24402">D3-Analis Kimia</option>
        </select>
        <label class="block text-gray-700 pt-3">Status:</label>
        <select v-model="form.status" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option value="sudah">Sudah Memilih</option>
          <option value="belum">Belum Memilih</option>
        </select>
      </search-filter>
      <dropdown class="" placement="bottom-end">
        <div class="flex items-center cursor-pointer select-none group">
          <div class="whitespace-no-wrap btn-green">
            <span>
              Action
            </span>
            <span>
              <i class="fas fa-caret-down pl-3" />
            </span>
          </div>
        </div>
        <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-center">
          <button class="block px-6 py-2 hover:bg-green-600 hover:text-white w-full text-center rounded-none" @click="toggleModal()">Import Mahasiswa</button>
          <a class="block px-6 py-2 hover:bg-green-600  hover:text-white" :href="route('mhs.export')">Export Mahasiswa</a>
          <inertia-link class="block px-6 py-2 hover:bg-green-600  hover:text-white" :href="route('mahasiswa.reset')">Reset Status</inertia-link>
        </div>
      </dropdown>
      <!--      <button class="modal-open btn-green" type="button" @click="toggleModal()">-->
      <!--        <span>Import</span>-->
      <!--        <span class="hidden md:inline">Mahasiswa</span>-->
      <!--      </button>-->
      <!--      <a class="btn-indigo" :href="route('mhs.export')">-->
      <!--        <span>Export</span>-->
      <!--        <span class="hidden md:inline">Mahasiswa</span>-->
      <!--      </a>-->
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-center font-bold">
          <th class="px-6 pt-6 pb-4">NIM</th>
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Kelas</th>
          <th class="px-6 pt-6 pb-4">Token</th>
          <th class="px-6 pt-6 pb-4">Status</th>
        </tr>
        <tr v-for="mhs in mahasiswa.data" :key="mhs.id" class="text-center hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t py-4">
            {{ mhs.nim }}
            <icon v-if="mhs.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4">
            {{ mhs.name }}
            <icon v-if="mhs.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4">
            {{ mhs.kelas.name }}
            <icon v-if="mhs.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4">
            {{ mhs.token }}
            <icon v-if="mhs.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4 font-bold">
            <span v-if="mhs.id_kandidat==null" class="btn-green rounded-full py-1">Belum Pilih</span>
            <span v-if="mhs.id_kandidat" class="btn-red rounded-full py-1">Sudah Pilih</span>
            <icon v-if="mhs.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
        </tr>
        <tr v-if="mahasiswa.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">Tidak ada data Mahasiswa Pemilih</td>
        </tr>
      </table>
    </div>
    <pagination :links="mahasiswa.links" />
    <!--Modal Import-->
    <card-modal :showing="showModal" @close="showModal = false">
      <h2 class="text-xl font-bold text-gray-900">Import Data Mahasiswa</h2>
      <p class="mt-3">
        Import file excel list mahasiswa sesuai format berikut :
      </p>
      <form @submit.prevent="importExcel()">
        <file-input v-model="user.excel" :error="errors.photo" class="pb-8 py-5 w-full w-auto z-50" type="file" accept=".xlsx, .xls, .csv" name="file" label="Excel" />
        <loading-button :loading="sending" class="btn-green float-right" type="submit">Import</loading-button>
      </form>
      <button
        class="btn-indigo"
        @click="showModal = false"
      >
        Close
      </button>
    </card-modal>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import Pagination from '@/Shared/Pagination'
import CardModal from '@/Shared/CardModal'
import SearchFilter from '@/Shared/SearchFilter'
import FileInput from '@/Shared/FileInput'
import LoadingButton from '@/Shared/LoadingButton'
import Dropdown from '@/Shared/Dropdown'
export default {
  metaInfo: { title: 'Mahasiswa' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
    CardModal,
    FileInput,
    LoadingButton,
    Dropdown,
  },
  props: {
    mahasiswa: Object,
    dataKelas:Array,
    filters: Object,
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        kelas: this.filters.kelas,
        prodi: this.filters.prodi,
        status:this.filters.status,
      },
      user:{
        excel : null,
      },
      showModal: false,
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('mahasiswa', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    toggleModal(){
      this.showModal = !this.showModal
    },
    importExcel(){
      const data = new FormData()
      data.append('file', this.user.excel || '')
      this.showModal = !this.showModal
      this.$inertia.post(this.route('mhs.import'), data, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>

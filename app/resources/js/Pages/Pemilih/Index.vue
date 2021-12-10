<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">List Pemilih</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Kelas:</label>
        <select v-model="form.angkatan" class="mt-1 w-full form-select">
          <option :value="null">All</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
        <label class="pt-3 block text-gray-700">Program Studi:</label>
        <select v-model="form.prodi" class="mt-1 w-full form-select">
          <option :value="null" selected>All</option>
          <option value="24301">D4-Teknik Kimia Produksi Bersih</option>
          <option value="24401">D3-Teknik Kimia</option>
          <option value="24402">D3-Analis Kimia</option>
        </select>
      </search-filter>
      <button class="btn-green float-right" @click="activeSemua">
        Aktifkan Semua
      </button>
      <!--      <loading-button :loading="sending" class="btn-green float-right" type="submit" @click="activeSemua">-->
      <!--        Aktifkan Semua-->
      <!--      </loading-button>-->
      <inertia-link :href="route('pemilih.nonaktif')">
        <loading-button :loading="sending" class="btn-indigo float-right" type="submit">
          Nonaktifkan Semua
        </loading-button>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap text-center">
        <tr class=" font-bold">
          <th class="px-6 pt-6 pb-4">Kelas</th>
          <th class="px-6 pt-6 pb-4">Program Studi</th>
          <th class="px-6 pt-6 pb-4">Status Pilih</th>
          <th class="px-6 pt-6 pb-4">Aksi</th>
        </tr>
        <tr v-for="data in kelas.data" :key="data.id" class="text-center hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t py-4">
            {{ data.name }}
            <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4">
            {{ data.prodi }}
            <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4">
            {{ data.status }}
            <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
          <td class="border-t py-4">
            <div v-if="data.status === 0">
              <inertia-link :href="route('pemilih.aktif.id',data.id)">
                <loading-button :loading="sending" class="btn-green m-auto" type="submit">
                  On
                </loading-button>
              </inertia-link>
            </div>
            <div v-if="data.status === 1">
              <inertia-link :href="route('pemilih.nonaktif.id',data.id)">
                <loading-button :loading="sending" class="btn-red m-auto" type="submit">
                  Off
                </loading-button>
              </inertia-link>
            </div>
            <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
          </td>
        </tr>
        <tr v-if="kelas.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">Tidak ada data Pemilih</td>
        </tr>
      </table>
    </div>
    <pagination :links="kelas.links" />
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
import Icon from '../../Shared/Icon'
import Layout from '../../Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '../../Shared/Pagination'
import CardModal from '../../Shared/CardModal'
import pickBy from 'lodash/pickBy'
import SearchFilter from '../../Shared/SearchFilter'
import throttle from 'lodash/throttle'
import FileInput from '../../Shared/FileInput'
import LoadingButton from '../../Shared/LoadingButton'
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
  },
  props: {
    kelas: Object,
    kelasAktif: Object,
    filters: Object,
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        angkatan:this.filters.angkatan,
        prodi:this.filters.prodi,
      },
      user:{
        excel : null,
      },
      showModal: false,
      activeLink : this.route('pemilih.aktif')+Object.keys(pickBy(this.form)),
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('pemilih', Object.keys(query).length ? query : { remember: 'forget' }))
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
    activeSemua(){
      let query = pickBy(this.form)
      var linkActive = Object.keys(query).length ?  this.route('pemilih.aktif2',query) : this.route('pemilih.aktif')
      // console.log(this.route('pemilih.aktif',Object.keys(query).length ? query : { remember: 'forget' }))
      // console.log(linkActive)
      this.$inertia.visit(linkActive)
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
<style scoped>
.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

.animated.faster {
    -webkit-animation-duration: 500ms;
    animation-duration: 500ms;
}

.fadeIn {
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
}

.fadeOut {
    -webkit-animation-name: fadeOut;
    animation-name: fadeOut;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }

    to {
        opacity: 0;
    }
}
</style>

<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Kandidat</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset" />
      <inertia-link :href="route('kandidat.create')">
        <loading-button :loading="sending" class="btn-indigo float-right" type="submit">
          Tambah Kandidat
        </loading-button>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-center font-bold">
          <th class="px-6 pt-6 pb-4">Nomor Urut</th>
          <th class="px-6 pt-6 pb-4">Nama</th>
          <th class="px-6 pt-6 pb-4">Foto</th>
        </tr>
        <tr v-for="data in kandidat.data" :key="data.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500 text-center" :href="route('kandidat.edit', data.id)">
              <span class="m-auto">{{ data.id }}</span>
              <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('kandidat.edit', data.id)">
              <span class="m-auto">{{ data.name }}</span>
              <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('kandidat.edit', data.id)">
              <img v-if="data.foto" class="block w-24 h-24 rounded-sm m-auto" :src="data.foto">
              <icon v-if="data.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('kandidat.edit', data.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="kandidat.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">Tidak ada data Pemilih</td>
        </tr>
      </table>
    </div>
    <pagination :links="kandidat.links" />
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
import Dropdown from '@/Shared/Dropdown'
export default {
  metaInfo: { title: 'Kandidat' },
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
    kandidat: Object,
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {

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
        this.$inertia.replace(this.route('kandidat', Object.keys(query).length ? query : { remember: 'forget' }))
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

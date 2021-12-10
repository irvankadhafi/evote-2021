<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Pemilih Aktif</h1>
    <div class="bg-white rounded shadow overflow-x-auto mb-5">
      <table class="w-full whitespace-no-wrap text-center">
        <tr class=" font-bold">
          <th class="px-6 pt-6 pb-4">Kelas</th>
          <th class="px-6 pt-6 pb-4">Program Studi</th>
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
        </tr>
        <tr v-if="kelas.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">Tidak ada data Pemilih</td>
        </tr>
      </table>
    </div>
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
/*.animated {*/
/*    -webkit-animation-duration: 1s;*/
/*    animation-duration: 1s;*/
/*    -webkit-animation-fill-mode: both;*/
/*    animation-fill-mode: both;*/
/*}*/

/*.animated.faster {*/
/*    -webkit-animation-duration: 500ms;*/
/*    animation-duration: 500ms;*/
/*}*/

/*.fadeIn {*/
/*    -webkit-animation-name: fadeIn;*/
/*    animation-name: fadeIn;*/
/*}*/

/*.fadeOut {*/
/*    -webkit-animation-name: fadeOut;*/
/*    animation-name: fadeOut;*/
/*}*/

/*@keyframes fadeIn {*/
/*    from {*/
/*        opacity: 0;*/
/*    }*/

/*    to {*/
/*        opacity: 1;*/
/*    }*/
/*}*/

/*@keyframes fadeOut {*/
/*    from {*/
/*        opacity: 1;*/
/*    }*/

/*    to {*/
/*        opacity: 0;*/
/*    }*/
/*}*/
</style>

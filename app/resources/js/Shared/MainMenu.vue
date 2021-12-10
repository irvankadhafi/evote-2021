<template>
  <div>
    <ul class="space-y-2 text-sm">
      <li>
        <inertia-link :href="route('dashboard')" :class="isUrl('admin/home') ? 'bg-gray-200' : 'focus:bg-gray-200'" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 ">
          <span class="text-gray-600">
            <i class="fas fa-home" />
          </span>
          <span>Dashboard</span>
        </inertia-link>
      </li>
      <li>
        <inertia-link :href="route('dashboard.hasil')" :class="isUrl('admin/hasil') ? 'bg-gray-200' : 'focus:bg-gray-200'" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200  ">
          <span class="text-gray-600">
            <i class="fas fa-poll" />
          </span>
          <span>Hasil Polling</span>
        </inertia-link>
      </li>
      <li v-if="$page.props.auth.user.owner" class="my-px">
        <span class="flex font-medium text-sm text-gray-400 px-2 my-2 uppercase">
          Kandidat
        </span>
      </li>
      <li v-if="$page.props.auth.user.owner">
        <inertia-link :href="route('kandidat')" :class="isUrl('admin/kandidat') ? 'bg-gray-200' : 'focus:bg-gray-200'" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200  ">
          <span class="text-gray-600">
            <i class="fas fa-users" />
          </span>
          <span>Daftar Kandidat</span>
        </inertia-link>
      </li>
      <li v-if="$page.props.auth.user.owner" class="my-px">
        <span class="flex font-medium text-sm text-gray-400 px-2 my-2 uppercase">
          Pemilih
        </span>
      </li>
      <li v-if="$page.props.auth.user.owner">
        <inertia-link :href="route('mahasiswa')" :class="isUrl('admin/mahasiswa') ? 'bg-gray-200' : 'focus:bg-gray-200'" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200  ">
          <span class="text-gray-600">
            <i class="fas fa-users" />
          </span>
          <span>Daftar Pemilih</span>
        </inertia-link>
      </li>
      <li v-if="$page.props.auth.user.owner">
        <inertia-link :href="route('pemilih')" :class="isUrl('admin/pemilih') ? 'bg-gray-200' : 'focus:bg-gray-200'" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200  ">
          <span class="text-gray-600">
            <i class="fas fa-users" />
          </span>
          <span>Kontrol Pemilih</span>
        </inertia-link>
      </li>
      <li v-if="$page.props.auth.user.owner">
        <inertia-link :href="route('pemilih.list')" :class="isUrl('admin/list-aktif') ? 'bg-gray-200' : 'focus:bg-gray-200'" class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200  ">
          <span class="text-gray-600">
            <i class="fas fa-users" />
          </span>
          <span>Daftar Aktif</span>
        </inertia-link>
      </li>
    </ul>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Dropdown from '@/Shared/Dropdown'
import DropdownMenu from '@/Shared/DropdownMenu'

export default {
  components: {
    Icon,Dropdown,DropdownMenu,
  },
  props: {
    url: String,
  },
  methods: {
    isUrl(...urls) {
      let URL = urls[0].split('/')
      if (URL[1] === '') {
        return this.url === ''
      }
      // console.log(this.$inertia.page.url+' + '+urls[0])
      return urls.filter(url => this.url.startsWith(url)).length
    },
  },
}
</script>

<template>
  <div>
    <div class="flex justify-between items-center">
      <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
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
          <a class="block px-6 py-2 hover:bg-green-600  hover:text-white" :href="route('hasil.export')">Export Hasil</a>
        </div>
      </dropdown>
    </div>


    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
      <!-- Card -->
      <div
        class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
      >
        <div
          class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
            />
          </svg>
        </div>
        <div>
          <p
            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
          >
            Total Mahasiswa
          </p>
          <p
            class="text-lg font-semibold text-gray-700 dark:text-gray-200"
          >
            {{ info.total_mahasiswa }}
          </p>
        </div>
      </div>
      <!-- Card -->
      <div
        class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
      >
        <div
          class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.323 12.667c.261.08.677.25.677.755 0 .336-.25.781-1.136.745-.614-.025-1.833.099-2.489.442.453 1.829.344 4.391-.844 4.391-.797 0-.948-.903-1.188-1.734-.859-2.985-2.577-3.532-4.343-3.802v-4.964c3.344 0 4.25-1.5 6.752-1.5 1.6 0 2.426.867 2.426 1.333 0 .167-.136.286-.479.312-.405.031-.367.406.016.477.634.117.913.457.913.771 0 .265-.198.511-.549.591-.418.095-.332.379.016.406.566.045.844.382.844.705 0 .282-.212.554-.63.61-.43.058-.29.368.014.462z" /></svg>
        </div>
        <div>
          <p
            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
          >
            Belum Memilih
          </p>
          <p
            class="text-lg font-semibold text-gray-700 dark:text-gray-200"
          >
            {{ info.belum_memilih }}
          </p>
        </div>
      </div>
      <!-- Card -->
      <div
        class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
      >
        <div
          class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.308 11.794c.418.056.63.328.63.61 0 .323-.277.66-.844.705-.348.027-.434.312-.016.406.351.08.549.326.549.591 0 .314-.279.654-.913.771-.383.07-.421.445-.016.477.344.026.479.146.479.312 0 .466-.826 1.333-2.426 1.333-2.501.001-3.407-1.499-6.751-1.499v-4.964c1.766-.271 3.484-.817 4.344-3.802.239-.831.39-1.734 1.187-1.734 1.188 0 1.297 2.562.844 4.391.656.344 1.875.468 2.489.442.886-.036 1.136.409 1.136.745 0 .505-.416.675-.677.755-.304.094-.444.404-.015.461z" /></svg>
        </div>
        <div>
          <p
            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
          >
            Sudah Memilih
          </p>
          <p
            class="text-lg font-semibold text-gray-700 dark:text-gray-200"
          >
            {{ info.sudah_memilih }}
          </p>
        </div>
      </div>
      <!-- Card -->
      <div
        class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
      >
        <div
          class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21.698 10.658l2.302 1.342-12.002 7-11.998-7 2.301-1.342 9.697 5.658 9.7-5.658zm-9.7 10.657l-9.697-5.658-2.301 1.343 11.998 7 12.002-7-2.302-1.342-9.7 5.657zm12.002-14.315l-12.002-7-11.998 7 11.998 7 12.002-7z" /></svg>
        </div>
        <div>
          <p
            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
          >
            Total Kelas
          </p>
          <p
            class="text-lg font-semibold text-gray-700 dark:text-gray-200"
          >
            {{ info.total_kelas }}
          </p>
        </div>
      </div>
    </div>
    <h1 class="mb-4 font-bold text-2xl">Grafik Keseluruhan</h1>
    <div class="flex flex-wrap mt-6">
      <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
        <p class="text-xl pb-3 flex items-center">
          <i class="fas fa-poll mr-3" /> Hasil Voting
        </p>
        <div class="p-6 bg-white rounded-lg shadow-xs">
          <bar :label="hasil_refresh.label" :chart-data="hasil_refresh.jumlah" style="height: 300px;" />
          <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
          >
            <!-- Chart legend -->
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
              />
              <span>{{ hasil.label[0] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
              />
              <span>{{ hasil.label[1] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
              />
              <span>{{ hasil.label[2] }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
        <p class="text-xl pb-3 flex items-center">
          <i class="fas fa-check mr-3" /> Suara Masuk
        </p>
        <div class="p-6 bg-white rounded-lg shadow-xs">
          <pie :label="['Sudah Vote','Belum Vote']" :chart-data="[info.sudah_memilih,info.belum_memilih]" style="height: 300px;" />
          <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
          >
            <!-- Chart legend -->
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
              />
              <span>Sudah Vote</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 rounded-full" style="background: rgb(239, 68, 68)"
              />
              <span>Belum Vote</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h1 class="mb-4 font-bold text-2xl mt-6">Grafik Tiap Angkatan</h1>
    <div class="flex flex-wrap mt-6 mb-6">
      <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
        <p class="text-xl pb-3 flex items-center">
          <i class="fas fa-poll mr-3" /> Hasil Voting Angkatan 2021
        </p>
        <div class="p-6 bg-white rounded-lg shadow-xs">
          <bar :label="angkatan1.label" :chart-data="angkatan1.jumlah" style="height: 300px;" />
          <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
          >
            <!-- Chart legend -->
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
              />
              <span>{{ hasil.label[0] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
              />
              <span>{{ hasil.label[1] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
              />
              <span>{{ hasil.label[2] }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
        <p class="text-xl pb-3 flex items-center">
          <i class="fas fa-poll mr-3" /> Hasil Voting Angkatan 2019
        </p>
        <div class="p-6 bg-white rounded-lg shadow-xs">
          <bar :label="angkatan2.label" :chart-data="angkatan2.jumlah" style="height: 300px;" />
          <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
          >
            <!-- Chart legend -->
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
              />
              <span>{{ hasil.label[0] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
              />
              <span>{{ hasil.label[1] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
              />
              <span>{{ hasil.label[2] }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-wrap mt-6 mb-6">
      <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
        <p class="text-xl pb-3 flex items-center">
          <i class="fas fa-poll mr-3" /> Hasil Voting Angkatan 2018
        </p>
        <div class="p-6 bg-white rounded-lg shadow-xs">
          <bar :label="angkatan3.label" :chart-data="angkatan3.jumlah" style="height: 300px;" />
          <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
          >
            <!-- Chart legend -->
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
              />
              <span>{{ hasil.label[0] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
              />
              <span>{{ hasil.label[1] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
              />
              <span>{{ hasil.label[2] }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
        <p class="text-xl pb-3 flex items-center">
          <i class="fas fa-poll mr-3" /> Hasil Voting Angkatan 2017
        </p>
        <div class="p-6 bg-white rounded-lg shadow-xs">
          <bar :label="angkatan4.label" :chart-data="angkatan4.jumlah" style="height: 300px;" />
          <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
          >
            <!-- Chart legend -->
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
              />
              <span>{{ hasil.label[0] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
              />
              <span>{{ hasil.label[1] }}</span>
            </div>
            <div class="flex items-center">
              <span
                class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
              />
              <span>{{ hasil.label[2] }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Bar from './Chart/Bar'
import Pie from './Chart/Pie'
import Dropdown from '@/Shared/Dropdown'
export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
  components: {
    Bar,
    Pie,
    Dropdown,
  },
  props: {
    hasil: Object,
    angkatan1:Object,
    angkatan2:Object,
    angkatan3:Object,
    angkatan4:Object,
    info: Object,
    errors: Object,
  },
  data(){
    return{
      hasil_refresh:this.refreshData(),
    }
  },
  mounted() {
    // setInterval(()=>{
    //   console.log('test '+JSON.stringify(this.hasil.jumlah))
    // },1000)
  },
  methods:{
    refreshData(){
      let data = Object.assign({}, this.hasil)
      return data
    },
  },
}
</script>

<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('kandidat')">Kandidat</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 mb-4 flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6" label="Nama Kandidat" />

          <label class="form-label pt-4" :for="form.visi">Visi</label>
          <vue-editor v-model="form.visi" :error="errors.visi" :editor-toolbar="customToolbar" class="pr-6" />

          <label class="form-label pt-4" :for="form.misi">Misi</label>
          <vue-editor v-model="form.misi" :error="errors.misi" :editor-toolbar="customToolbar" class="pr-6" />

          <file-input v-model="form.foto" :error="errors.foto" class="pr-6 pt-4" type="file" accept="image/*" label="Foto Kandidat" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <button v-if="!kandidat.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Kandidat</button>

          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { VueEditor } from 'vue2-editor'
import Layout from '../../Shared/Layout'
import LoadingButton from '../../Shared/LoadingButton'
import SelectInput from '../../Shared/SelectInput'
import TextInput from '../../Shared/TextInput'
import FileInput from '../../Shared/FileInput'

export default {
  metaInfo: { title: 'Edit Kandidat' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    FileInput,
    VueEditor,
  },
  props: {
    errors: Object,
    kandidat: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.kandidat.name,
        visi: this.kandidat.visi,
        misi: this.kandidat.misi,
        foto: null,
      },
      customToolbar: [
        ['bold', 'italic', 'underline','strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' },{ 'list': 'check' }],
        [{ 'align': ''}, { 'align': 'center' },{ 'align': 'right' },{ 'align': 'justify' }],
        ['image'],['blockquote'],[{'color':['#fff','#000','#ff0000']}],
      ],
    }
  },
  methods: {
    destroy() {
      if (confirm('Are you sure you want to delete this kandidat?')) {
        this.$inertia.delete(this.route('kandidat.delete', this.kandidat.id))
      }
    },
    submit() {
      var data = new FormData()
      data.append('name', this.form.name || '')
      data.append('visi', this.form.visi || '')
      data.append('misi', this.form.misi || '')
      data.append('foto', this.form.foto || '')
      data.append('_method', 'put')
      this.$inertia.post(this.route('kandidat.update',this.kandidat.id), data, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
        onSuccess: () => {
          if (Object.keys(this.$page.errors).length === 0) {
            this.form.foto = null
          }
        },
      })
    },
  },
}
</script>

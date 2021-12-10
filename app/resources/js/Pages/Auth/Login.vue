<template>
  <div class="overflow-y-auto h-screen" scroll-region>
    <!--      <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">-->
    <!--          <div class="w-full max-w-md">-->
    <!--              <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />-->
    <!--              <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="submit">-->
    <!--                  <div class="px-10 py-12">-->
    <!--                      <h1 class="text-center font-bold text-3xl">Welcome Back!</h1>-->
    <!--                      <div class="mx-auto mt-6 w-24 border-b-2" />-->
    <!--                      <text-input v-model="form.email" :error="errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />-->
    <!--                      <text-input v-model="form.password" class="mt-6" label="Password" type="password" />-->
    <!--                      <label class="mt-6 select-none flex items-center" for="remember">-->
    <!--                          <input id="remember" v-model="form.remember" class="mr-1" type="checkbox">-->
    <!--                          <span class="text-sm">Remember Me</span>-->
    <!--                      </label>-->
    <!--                  </div>-->
    <!--                  <div class="px-10 py-4 bg-gray-100 border-t border-gray-200 flex justify-between items-center">-->
    <!--                      <a class="hover:underline" tabindex="-1" href="#reset-password">Forget password?</a>-->
    <!--                      <loading-button :loading="sending" class="btn-indigo" type="submit">Login</loading-button>-->
    <!--                  </div>-->
    <!--              </form>-->
    <!--          </div>-->
    <!--      </div>-->
    <!-- component -->
    <div class="container">
      <div class="fixed h-full w-full flex items-center justify-center px-6">
        <!-- Row -->
        <div class="w-full xl:w-3/4 lg:w-11/12 flex">
          <!-- Col -->
          <div
            class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/7hww7t6NLcg/600x800')"
          />
          <!-- Col -->
          <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center">Welcome Back!</h3>
            <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" @submit.prevent="submit">
              <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                  Username
                </label>
                <text-input
                  id="email"
                  v-model="form.email"
                  label="Email"
                  :error="errors.email"
                  type="text"
                  placeholder="Email"
                />
              </div>
              <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                  Password
                </label>
                <text-input
                  id="password"
                  v-model="form.password"
                  type="password"
                  label="Password"
                  placeholder="******************"
                />
              </div>
              <div class="mb-4">
                <input id="checkbox_id" v-model="form.remember" class="mr-2 leading-tight" type="checkbox">
                <label class="text-sm" for="checkbox_id">
                  Remember Me
                </label>
              </div>
              <div class="mb-6 text-center w-full flex items-center justify-center ">
                <loading-button :loading="sending" class="py-2 w-full font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline items-center justify-center" type="submit">Login</loading-button>
                <!--                              <button-->
                <!--                                  class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"-->
                <!--                                  type="submit"-->
                <!--                              >-->
                <!--                                  Sign In-->
                <!--                              </button>-->
              </div>
              <hr class="mb-6 border-t">
              <div class="text-center">
                <a
                  class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                  href="#register"
                >
                  Create an Account!
                </a>
              </div>
              <div class="text-center">
                <a
                  class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                  href="#forgot-password"
                >
                  Forgot Password?
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingButton from '../../Shared/LoadingButton'
import Logo from '../../Shared/Logo'
import TextInput from '../../Shared/TextInput'

export default {
  metaInfo: { title: 'Login' },
  components: {
    LoadingButton,
    Logo,
    TextInput,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        // email: 'irvankadhafi04@gmail.com',
        // password: 'irvan456',
        email: '',
        password: '',
        remember: null,
      },
    }
  },
  methods: {
    submit() {
      const data = {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      }

      this.$inertia.post(this.route('login.attempt'), data, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>

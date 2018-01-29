<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card title="Login">
        <form @submit.prevent="login">
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-7">
              <input v-model="email" type="email" name="email" class="form-control">
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Password</label>
            <div class="col-md-7">
              <input v-model="password" type="password" name="password" class="form-control">
              <div class="invalid-credentials">{{ errorMessage }}</div>
            </div>
          </div>

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-3"></div>
            <div class="col-md-7 d-flex">
              <checkbox v-model="remember" name="remember">
              Rremember Me
              </checkbox>

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                Forgot Password
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="busy">
                Login
              </v-button>

              <!-- GitHub Login Button -->
              <login-with-github/>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  head () {
    return { title: 'Login' }
  },

  data: () => ({
    email: '',
    password: '',
    remember: false,
    errorMessage: '',
    busy: false
  }),

  methods: {
    async login () {
      this.errorMessage = ''
      this.busy = true
      // Submit the form.
      const authUrl = axios.create({
        // Fill baseURL with current base url
        baseURL: window.location.origin?window.location.origin+'/':window.location.protocol+'/'+window.location.host
      })
      const params = {
        email: this.email,
        password: this.password
      }
      const { data } = await authUrl.post('/auth', params)

      if (!data.error) {
        // Save the token.
        this.$store.dispatch('auth/saveToken', {
          token: data.access_token,
          remember: this.remember
        })
        // Fetch the user.
        await this.$store.dispatch('auth/fetchUser')

        // Redirect home.
        this.$router.push({ name: 'home' })
      } else {
        this.busy = false
        this.errorMessage = data.message
      }
    }
  }
}
</script>

<style>
.invalid-credentials {
  width: 100%;
  margin-top: 4px;
  margin-top: 0.25rem;
  font-size: 80%;
  color: #dc3545;
}
</style>

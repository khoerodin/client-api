<template>
  <card title="Your Info">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" message="Info Updated"/>

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Name</label>
        <div class="col-md-7">
          <input v-model="form.name" type="text" name="name" class="form-control"
            :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"/>
        </div>
      </div>

      <!-- Email -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Email</label>
        <div class="col-md-7">
          <input v-model="form.email" type="email" name="email" class="form-control"
            :class="{ 'is-invalid': form.errors.has('email') }">
          <has-error :form="form" field="email"/>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button type="success" :loading="form.busy">Update</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  head () {
    return { title: 'Settings' }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>

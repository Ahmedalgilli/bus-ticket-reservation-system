<template>
  <v-row>
    <v-col cols="12">
      <user-form v-bind:form.sync="form"></user-form>
    </v-col>

    <v-col cols="12">
      <v-btn :loading="sending" color="primary" @click="submit">Create Manager</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/Layout'

export default {
  metaInfo: {
    title: 'Create Manager',
    goBack: {
      title: 'Users',
      url: 'admin.users.index',
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props:{
    roles: Array,
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    rolesData: null,
    form: {
      first_name: null,
      last_name: null,
      email: null,
      password: null,
      role_id: null,
    },
  }),
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('admin.users.store'), this.form)
        .then(() => this.sending = false)
    },
  },
  created(){
    this.rolesData = this.roles.map(role => {
      return { value : role.id, text : role.name }
    })
    this.form.roles = this.rolesData
  }
}
</script>

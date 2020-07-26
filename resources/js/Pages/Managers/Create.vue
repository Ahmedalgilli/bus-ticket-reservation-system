<template>
  <v-row>
    <v-col cols="12">
      <employee-form v-bind:form.sync="form"></employee-form>
    </v-col>

    <v-col cols="12">
      <v-btn :loading="sending" color="primary" @click="submit">Save Employee</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/ManagerLayout'

export default {
  metaInfo: {
    title: 'Create Employee',
    goBack: {
      title: 'Employees',
      url: 'managers.users.index',
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
    },
  }),
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('managers.employees.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>

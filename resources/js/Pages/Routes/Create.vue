<template>
  <v-row>
    <v-col cols="12">
      <route-form v-bind:form.sync="form"></route-form>
    </v-col>

    <v-col cols="12">
      <v-btn :loading="sending" color="primary" @click="submit">Save Route</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo: {
    title: 'Create Route',
    goBack: {
      title: 'Route',
      url: 'routes.index',
    }
  },

  layout: (h, page) => h(Layout, [page]),

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      from: null,
      to: null,
      duration: null,
    },
  }),
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('routes.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>

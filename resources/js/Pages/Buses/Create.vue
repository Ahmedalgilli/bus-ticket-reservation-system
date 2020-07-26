<template>
  <v-row>
    <v-col cols="12">
      <bus-form v-bind:form.sync="form"></bus-form>
    </v-col>

    <v-col cols="12">
      <v-btn :loading="sending" color="primary" @click="submit">Save Bus</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo: {
    title: 'Create Bus',
    goBack: {
      title: 'Buses',
      url: 'buses.index',
    }
  },

  layout: (h, page) => h(Layout, [page]),

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      name: null,
      license_plate_number: null,
      seats_number: null,
    },
  }),
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('buses.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>

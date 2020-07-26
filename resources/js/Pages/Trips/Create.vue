<template>
  <v-row>
    <v-col cols="12">
      <trip-form v-bind:form.sync="form"></trip-form>
    </v-col>

    <v-col cols="12">
      <v-btn :loading="sending" color="primary" @click="submit">Save Trip</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo: {
    title: 'Create Trip',
    goBack: {
      title: 'Trips',
      url: 'trips.index',
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props:{
    buses: Array,
    routes: Array
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    routesData: null,
    busesData: null,
    form: {
      seat_number: null,
      price: null,
      weight: null,
      date: null,
    },
  }),
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('trips.store'), this.form)
        .then(() => this.sending = false)
    },
  },
  created(){
    this.busesData = this.buses.map(bus => {
      return { value : bus.id, text : bus.name }
    })
    this.routesData = this.routes.map(route => {
      return { value : route.id, text : `${route.from} - ${route.to}` }
    })
    this.form.buses = this.busesData
    this.form.routes = this.routesData
  }
}
</script>

<template>
  <v-row>
    <v-col cols="12" v-if="trip.deleted_at">
      <trashed-banner @restore="restore">
        This trip has been deleted.
      </trashed-banner>
    </v-col>

    <v-col cols="12">
      <trip-form v-bind:form.sync="form"></trip-form>
    </v-col>

    <v-col cols="12" class="py-0">
      <v-btn v-if="!trip.deleted_at" color="warning" @click="destroy">Delete Trip</v-btn>
      <v-btn :loading="sending" color="primary" @click="submit">Update Trip</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo() {
    return {
      title: `${this.trip.route.from} - ${this.trip.route.to} - ${this.trip.date}`,
      goBack: {
        title: 'Trips',
        url: 'trips.index',
      }
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props: {
    trip: Object,
    buses: Array,
    routes: Array
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      ...vm.trip
    },
  }),

  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('trips.update', this.trip.id), this.form)
        .then(() => this.sending = false)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this trip?')) {
        this.$inertia.delete(this.route('trips.destroy', this.trip.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this trip?')) {
        this.$inertia.put(this.route('trips.restore', this.trip.id))
      }
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

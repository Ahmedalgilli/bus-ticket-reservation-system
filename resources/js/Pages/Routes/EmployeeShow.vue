<template>
  <v-row>

    <v-col cols="6" v-for="trip in _route.allTrips" :key="trip.id">
        <v-card class="ma-3">
          <!-- <v-card-media src="src" height="200px">
          </v-card-media> -->
          <v-card-title primary-title>
            <div>
              <h3 class="headline ma-2">{{ 'Trip Date  : ' + trip.date }}</h3>
              <div class="ma-3">{{ 'Available Seats Number : ' + trip.seats_number }}</div>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn link @click="$inertia.visit(route('trips.booking', trip.id))" flat color="primary">view</v-btn>
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
    </v-col>

  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo() {
    return {
      title: `${this._route.from} - ${this._route.to}`,
      goBack: {
        title: 'Routes',
        url: 'routes.index',
      }
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props: {
    _route: Object,
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      ...vm._route
    },
  }),

  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('routes.update', this._route.id), this.form)
        .then(() => this.sending = false)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this route?')) {
        this.$inertia.delete(this.route('routes.destroy', this._route.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this route?')) {
        this.$inertia.put(this.route('routes.restore', this._route.id))
      }
    },
  },
}
</script>

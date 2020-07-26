<template>
  <v-row>
    <v-col cols="4">
    <!-- <v-col cols="4" v-for="trip in _route.allTrips" :key="trip.id">
        <v-card >
           <v-card-media src="src" height="200px">
          </v-card-media>
          <v-card-title primary-title>
            <div>
              <h3 class="headline mb-0">{{ 'Trip Date  : ' + trip.date }}</h3>
              <div>{{ 'available Seats Number : ' + trip.seats_number }}</div>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn flat color="primary">text</v-btn>
            <v-btn flat color="primary">text</v-btn>
          </v-card-actions>
        </v-card> -->
        <v-list-item-group
            active-class="light-blue lighten-5 blue--text text--darken-4"
        >
            <v-list-item v-for="trip in _route.allTrips" :key="trip.id" link @click="$inertia.visit(route('trips.booking', trip.id))" :value="`/trips/${trip.id}/booking`">
                <v-list-item-content>
                    <v-list-item-title>
                    {{ 'Trip Date ' + trip.date + ' and available Seats Number is ' + trip.seats_number}}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list-item-group>
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

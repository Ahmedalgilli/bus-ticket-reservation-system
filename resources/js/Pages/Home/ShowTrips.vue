<template>
    <v-row>
        <v-col v-for="trip in trips" :key="trip.id" cols="4" lg="3" sm="12">
            <v-card class="elevation-10">
                <v-card-title class="ma-2" primary-title>
                    <div>
                        <h5 class="">{{ trip.company + ' Company'}}</h5>
                    </div>
                </v-card-title>
                <v-card-text class="ma-3">
                    <div>{{ 'Avalable Tickets ' + trip.available_tikcets }}</div>
                    <div>{{ 'Booked Tickets ' + trip.booked_tikcets }}</div>
                    <div>{{ 'Price ' + trip.price }}</div>
                    <div>{{ 'Date ' + trip.date }}</div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :loading="sending" @click="submit(trip.id)" flat color="primary">Select</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import BaseLayout from '@shared/BaseLayout'
import RouteList from '../../Components/Shared/RouteList'

export default {
  name: "ShowTripsForUser",
  metaInfo: {
    title: 'Trips Page'
  },

  layout: (h, page) => h(BaseLayout, [page]),
  props: {
    trips: Array,
    data: Object
  },
  data(vm) {
    return {
        sending: false
    }
  },
  methods: {
    submit(id){
      this.sending = true
      this.$inertia.visit(this.route('search.booking', id))
    },
  },
  created(){
      console.log(this.trips)
    // this.data = this.routes
  }
}
</script>

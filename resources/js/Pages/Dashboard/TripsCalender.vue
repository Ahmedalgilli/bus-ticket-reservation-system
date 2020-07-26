<template>
  <v-row>
    <v-col cols="12">
      <h1>Booking</h1>
    </v-col>

    <v-col cols="12">
      <Calender :allEvents="events" />
    </v-col>
    <v-col cols="12">
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/Layout'
import Calender from '../../Components/Calender'

export default {
  props:{
    events: Array,
  },
  components: {
    Calender
  },
  metaInfo: { title: 'Dashboard' },
  layout: (h, page) => h(Layout, [page]),
  created(){
    console.log(this.events)
  }
}
</script>

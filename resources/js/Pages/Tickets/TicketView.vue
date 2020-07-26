<template>
    <v-row>
        <v-col cols="12" lg="12" sm="12">
            <h3>Invoice Print</h3>
        </v-col>
        <v-col v-for="ticket in tickets"
         :key="ticket.id" cols="6" lg="6" sm="12">
            <v-card class="elevation-12">
                <v-card-title class="ma-2" primary-title>
                    <div>
                        <h5 class="">{{ customer_pay_data.company.first_name + ' Company'}}</h5>
                    </div>
                </v-card-title>
                <v-card-text class="ma-5">
                    <div>{{ 'From ' + ticket.route.from + ' To ' + ticket.route.to }}</div>
                    <div>{{ 'Customer Id : ' + ticket.customer_id }}</div>
                    <div>{{ 'Customer Name : ' + ticket.customer.name }}</div>
                    <div>{{ 'Customer Phone : ' + ticket.customer.phone }}</div>
                    <div>{{ 'Seat Number : ' + ticket.seat_number }}</div>
                    <div>{{ 'Trip Date : ' + customer_pay_data.trip.date }}</div>
                    <div>{{ 'Ticket Number : ' + ticket.id }}</div>
                    <div>{{ 'Invoice Id : ' + ticket_number }}</div>
                    <div>{{ 'Pay Method : ' + method_id }}</div>
                    <!-- <div>{{ 'Price ' + ticket.price }}</div> -->
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :loading="sending" 
                    @click="submit(customer_pay_data.id)" flat color="primary">Print</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import BaseLayout from '@shared/BaseLayout'

export default {
  name: "TicketView",
  metaInfo: {
    title: 'Ticket Info Page'
  },

  layout: (h, page) => h(BaseLayout, [page]),
  props: {
    tickets: Array,
    customer_pay_data: Array,
    method_id: String,
    ticket_number: String
  },
  data(vm) {
    return {
        sending: false
    }
  },
  methods: {
    submit(id){
      // this.sending = true
      // this.$inertia.visit(this.route('print', id))
    },
  },
  created(){
      console.log(this.customer_pay_data)
      console.log(JSON.parse(this.customer_pay_data.invoice.customers))
  }
}
</script>

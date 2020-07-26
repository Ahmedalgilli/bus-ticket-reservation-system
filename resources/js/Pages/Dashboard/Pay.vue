<template>
  <v-row>
    <v-col cols="12">
        <h1>Payment Methods For Invoice Number {{ 'TN' + customer_pay_data.ticket_number }}</h1>
    </v-col>
    <v-col cols="4" v-for="provider in pay_provider" :key="provider.id">
        <v-card>
            <v-card-text>
                {{ provider.name }}
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn class="ma-2" @click="submit(provider.name)" color="primary">Pay</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/BaseLayout'

export default {
  metaInfo: { title: 'Invoice' },

  layout: (h, page) => h(Layout, [page]),

  props: {
    customer_pay_data: Object
  },

  data: vm => ({
    ticket_number: null,
    pay_provider: [ 
        { id: 1, name: 'MBok'}, 
        { id: 2, name: 'FIB'}, 
        { id: 3, name: 'SAYBER-PAY'}, 
    ],
  }),

  methods: {
    submit(method) {
      this.sending = true
      console.log(method)
      console.log(this.ticket_number)
      this.$inertia.visit(this.route('bookings.pay.methods', [ this.ticket_number, method ]))
    },
  },
  created(){
    this.ticket_number = this.customer_pay_data.ticket_number
    console.log(this.customer_pay_data.ticket_number)
  }
}
</script>

<template>
  <v-row>
    <v-col cols="12">
        <h3 class="ma-2">Payment Methods For Invoice Number {{ 'TN' + customer_pay_data.ticket_number }}</h3>
    </v-col>
    <v-col cols="12">
        <v-card>
            <v-card-title primary-title>
              <div>
                <h5 class="headline ma-2">{{ 'Pay ' + method }}</h5>
                <!-- <div class="ma-3">{{ 'Available Seats Number : ' + trip.seats_number }}</div> -->
              </div>
            </v-card-title>
            <v-card-text>
                <v-row class="ma-2">
                  <v-col cols="12" lg="4">
                      <v-text-field
                      v-model="company_acount_number"
                      :error-messages="$page.errors.company_acount_number"
                      label="Company Acount Number"
                      disabled
                      outlined
                      ></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4">
                      <v-text-field
                      v-model="customer_pay_data.total"
                      label="Total Price"
                      outlined
                      disabled
                      ></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4">
                      <v-text-field
                      v-model="customer_acount_number"
                      :error-messages="$page.errors.customer_acount_number"
                      label="Customer Acount Number"
                      type="number"
                      outlined
                      ></v-text-field>
                  </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn class="ma-2" @click="submit" color="primary">Pay</v-btn>
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
    customer_pay_data: Object,
    method: String
  },

  data: vm => ({
    ticket_number: null,
    company_acount_number: '1361554',
    customer_acount_number: '',
    form: {
      total : null,
      customer_acount_number : null,
      company_acount_number : null,
    },
  }),

  methods: {
    submit(method_id) {
      this.sending = true
      this.form.total = this.total
      this.form.customer_acount_number = this.customer_acount_number
      this.form.company_acount_number = this.company_acount_number
      this.$inertia.post(this.route('bookings.pay.methods.store', [ this.customer_pay_data.ticket_number, this.method ] ), this.form)
    },
  },
  created(){
    console.log(this.customer_pay_data)
  }
}
</script>

<template>
  <v-row class="ma-5">
    <v-col cols="12">
        <v-card class="ma-5">
            <v-card-title primary-title>
              <div>
                <h5 class="headline ma-2">{{ 'Pleas Enter Ticket Number' }}</h5>
              </div>
            </v-card-title>
            <v-card-text>
                <v-row >
                  <v-col cols="6" lg="4">
                      <v-text-field
                      v-model="ticket"
                      :error-messages="$page.errors.ticket"
                      label="Ticket Number"
                      type="number"
                      outlined
                      ></v-text-field>
                  </v-col>
                  <v-col cols="6" lg="4">
                        <v-btn class="ma-2" @click="submit" color="primary">Send Request</v-btn>
                  </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/BaseLayout'

export default {
  metaInfo: { title: 'Cancel Ticket Request' },

  layout: (h, page) => h(Layout, [page]),

  data: vm => ({
    ticket: null,
  }),

  methods: {
    submit(method_id) {
      this.sending = true
      this.$inertia.post(this.route('bookings.cancel_ticket_store', this.ticket))
    },
  },
  created(){
    // console.log(this.customer_pay_data)
  }
}
</script>

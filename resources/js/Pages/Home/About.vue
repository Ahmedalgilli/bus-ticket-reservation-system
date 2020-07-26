<template>
  <v-row class="ma-5">
    <v-col cols="12">
        <v-card class="ma-5">
            <v-card-title primary-title>
              <div>
                <h5 class="headline ma-2">{{ 'ABOUT US' }}</h5>
              </div>
            </v-card-title>
            <v-card-text>
                AN ONLINE BUS TICKET RESERVATION SYSTEM FOR A TRANSPORTATION SERVICE IN SUDAN <br>

                A Partial Fulfilment Graduation Project <br>

                Submitted to the Undergraduate Studies Programme <br>

                UNIVERSITY OF KHARTOUM <br>

                Faculty of mathematical science <br>
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

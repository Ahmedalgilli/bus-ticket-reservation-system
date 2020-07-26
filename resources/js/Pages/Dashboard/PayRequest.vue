<template>
  <v-row>
    <v-col cols="12">
        <h1>Pleas Enter Invoice Number</h1>
    </v-col>
    <v-col cols="12" justify-center>
        <v-card class="ma-4">
            <v-card-text>
                <v-col lg="4" md="6" sm="12">
                    <v-text-field
                    v-model="ticket_number"
                    :error-messages="$page.errors.ticket_number"
                    label="Invoice Number"
                    type="text"
                    outlined
                    ></v-text-field>
                </v-col>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn :loading="sending" class="ma-2" @click="submit" color="primary">Pay</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/BaseLayout'

export default {
  metaInfo: { title: 'Pay For Invoice' },

  layout: (h, page) => h(Layout, [page]),

  data: vm => ({
    ticket_number: null,
    sending: null
  }),

  methods: {
    submit() {
      this.sending = true
      console.log(this.ticket_number)
      this.$inertia.visit(this.route('bookings.pay', this.ticket_number))
    },
  },
  created(){
  }
}
</script>

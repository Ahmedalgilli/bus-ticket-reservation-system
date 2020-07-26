<template>
  <v-card
    class="mx-auto mb-3"
    dark
  >

    <v-row v-for="(customer_seat_number,i) in customer_seats_numbers" :key="i" class="ma-2">
        <v-col cols="12" lg="4">
            <v-text-field
            v-model="form[i].name"
            :error-messages="$page.errors.name"
            label="Passenger Name"
            outlined
            ></v-text-field>
        </v-col>
        <v-col cols="12" lg="4">
            <v-text-field
            v-model="form[i].phone"
            :error-messages="$page.errors.phone"
            label="Passenger Phone Number"
            outlined
            ></v-text-field>
        </v-col>
        <v-col  cols="4">
            <v-card class="ma-2">
              <v-card flat class="ma-2 mr-2">
                {{ 'ticket Number' }} : {{ form[i].ticket.id }}
              </v-card>
              <v-card flat class="ma-2 mr-2">
                {{ 'ticket Seat Number' }} : {{ form[i].ticket.seat_number }}
              </v-card>
              <v-card flat class="ma-2 mr-2">
                {{ 'ticket status' }} : {{ form[i].ticket.status }}
              </v-card>
              <!-- <v-card>
                {{ 'ticket price' }} : {{ form[i].ticket.price }}
              </v-card> -->
            </v-card>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="5" class="ma-3">
            <v-btn :loading="sending" color="primary" @click="submit">Continue</v-btn>
        </v-col>
        <v-spacer></v-spacer>
        <v-col cols="3">
            <v-btn :loading="sending" color="grey" @click="back">back</v-btn>
        </v-col>
    </v-row>

  </v-card>
</template>

<script>
import Layout from '@shared/EmployeeLayout'
  export default {
    props: {
        customer_seats_numbers: Array
    },
    metaInfo: {
        title: 'Step Tow',
        goBack: {
        title: 'Booking',
        url: 'booking.step_tow',
        }
    },

    layout: (h, page) => h(Layout, [page]),

    remember: 'form',

    data: () => ({
        sending: false,
        form: []
    }),

    methods: {
      submit(){
        this.sending = true
        this.$inertia.post(this.route('booking.step_tow_store'), this.form)
      },
      back(){
        this.sending = true
        this.$inertia.get(this.route('booking.step_one'))
      }
    },

    created(){
        for (let index = 0; index < this.customer_seats_numbers.length; index++) {
            this.form[index] = {
              name: null,
              phone: null,
              ticket: this.customer_seats_numbers[index],
            }
        }
        console.log(this.form)
    }
  }
</script>
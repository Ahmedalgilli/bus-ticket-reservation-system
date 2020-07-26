<template>
  <v-card
    class="mx-auto mb-3"
    dark
  >

    <v-row>
      <v-col cols="4">
        <v-card class="ma-6" dark color="grey">
          <v-card-text>
            Taken
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card class="ma-6" dark color="info">
          <v-card-text>
            Avilable
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card class="ma-6" dark color="success">
          <v-card-text>
            Selected
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row
      class="px-2 pb-2 ma-0"
      justify="space-between"
      v-for="(row,index) in rows"
      :key="index"
    >
      <v-btn-toggle
        v-model="formatting"
        multiple
      >
        <v-row dense>
          <v-col
            v-for="ticket in row"
            :key="ticket.id"
            class="title grey--text font-weight-regular text--darken-2"
          >
          <v-btn class="ma-4" :disabled="ticket.customer_id != null" :color="ticket.status == false ? 'info' : 'success'" @click="add(ticket)">{{ ticket.seat_number }}</v-btn></v-col>
        </v-row>

      </v-btn-toggle>

    </v-row>

    <v-card-actions>
      <v-btn
        color="primary"
        @click="submit"
        class="ma-4"
      >
        Continue
      </v-btn>

      <v-btn class="ma-4" text>Back</v-btn>
      <!-- <v-btn link @click="$inertia.visit(route('home'))" value="/" class="ma-4" text>Back</v-btn> -->
    </v-card-actions>


  </v-card>
</template>

<script>
import Layout from '@shared/EmployeeLayout'
  export default {
    props: {
        tickets: Array,
        // customer_seats_numbers: Array
    },
    metaInfo: {
        title: 'Step One',
        goBack: {
        title: 'Booking',
        url: 'booking',
        }
    },

    layout: (h, page) => h(Layout, [page]),

     data: () => ({
      alignment: 1,
      check: 1,
      formatting: [],
      rows: [ [], [], [], [], [] ],
      one: [],
      rowOne: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 41],
      rowTow: [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 42],
      rowThree: [43],
      rowFour: [21, 23, 25, 27, 29, 31, 33, 35, 37, 39, 44],
      rowFive: [22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 45],
      customer_tickets: [],
    }),
    methods: {
      add(ticket){
        if(this.customer_tickets.includes(ticket)){
          this.tickets[ticket.seat_number-1].status = false
          this.remove(ticket)
          this.rows = [ [], [], [], [], [] ]
          this.init()
        }else{
          this.customer_tickets.push(ticket)
          this.tickets[ticket.seat_number-1].status = true
          this.rows = [ [], [], [], [], [] ]
          this.init()
        }
          console.log(this.customer_tickets)
      },
      remove(ticket){
        const index = this.customer_tickets.indexOf(ticket);
        if (index > -1) {
          this.customer_tickets.splice(index, 1);
        }
      },
      find(element, array){
        this.check = false
        for (let index = 0; index < array.length; index++) {
          if(array[index] == element){
            this.check = true
          }
        }
        return this.check
      },
      submit(){
        this.sending = true
        this.$inertia.post(this.route('booking.step_one_store'), this.customer_tickets)
      },
      init(){

        for (let index = 0; index < this.tickets.length; index++) {
          if(this.find(this.tickets[index].seat_number, this.rowOne)){
            this.rows[0].push(this.tickets[index])
          }
          if(this.find(this.tickets[index].seat_number, this.rowTow)){
            this.rows[1].push(this.tickets[index])
          }
          if(this.find(this.tickets[index].seat_number, this.rowThree)){
            this.rows[2].push(this.tickets[index])
          }
          if(this.find(this.tickets[index].seat_number, this.rowFour)){
            this.rows[3].push(this.tickets[index])
          }
          if(this.find(this.tickets[index].seat_number, this.rowFive)){
            this.rows[4].push(this.tickets[index])
          }
        }

      }
    },
    created(){
      this.init()
      console.log(this.rows)
    }
  }
</script>
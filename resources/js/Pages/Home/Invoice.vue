<template>
  <v-row>
    <v-col cols="12">
      <data-table-wrapper
        :items="data"
        :headers="headers"
        sort-by="name"
      >
        <template #item="{ item }">
          <tr>
            <td>
              {{ item.id }}
            </td>
            <td>
              {{ item.name }}
            </td>
            <td>{{ item.phone }}</td>
            <!-- <td>{{ item.ticket.id }}</td> -->
            <td>{{ item.ticket.seat_number }}</td>
            <td>{{ item.ticket.price }}</td>
          </tr>
        </template>
      </data-table-wrapper>
    </v-col>
    <v-col>
        <v-card>
            <v-card-text>
                Total Price Is : {{ total }} SDG
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn class="ma-2" @click="submit" color="primary">Pay</v-btn>
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
    customers: Array,
    data: Array
  },

  data: vm => ({
    total: null,
    sum: 0,
    price: null,
	invoice: [],
	invoice_data: [],
    headers: [
      {text: 'ID', value: 'id'},
      {text: 'Name', value: 'name'},
      {text: 'Phone', value: 'phone'},
      // {text: 'Ticket Number', value: 'ticket.id'},
      {text: 'Seat Number', value: 'ticket.seat_number'},
      {text: 'Ticket Price', value: 'ticket.price'},
    //   {text: '', sortable: false},
    ],
  }),

  methods: {
    create() {
      this.$inertia.visit(route('customers.create'))
    },
    submit() {
		this.sending = true
		// console.log(this.invoice_data)
		const req_data = this.invoice_data
		console.log(req_data)
		this.$inertia.post(this.route('bookings.store'), this.invoice)
    },
    edit(_invices) {
      this.$inertia.visit(route('customers.edit', _invices))
    },
  },
  created(){
	this.invoice = this.customers
	this.invoice_data['user_id'] = this.invoice[0].user_id
	this.invoice_data['customer_id'] = this.invoice[0].ticket.customer_id
	this.invoice_data['trip_id'] = this.invoice[0].ticket.trip_id
	this.invoice_data['bus_id'] = this.invoice[0].ticket.bus_id
	this.invoice_data['ticket_id'] = this.invoice[0].ticket.id
	this.invoice_data['data'] = this.customers
	console.log(this.customers)
	for (let index = 0; index < this.customers.length; index++) {
		this.price = parseInt(this.customers[index].ticket.price);
		this.invoice[index].price = this.price
		this.invoice[index].user_id = parseInt(this.customers[index].ticket.user_id)
		this.invoice[index].customer_id = parseInt(this.customers[index].ticket.customer_id)
		this.invoice[index].trip_id = parseInt(this.customers[index].ticket.trip_id)
		this.invoice[index].bus_id = parseInt(this.customers[index].ticket.bus_id)
		this.invoice[index].ticket_id = parseInt(this.customers[index].ticket.id)
		this.sum = this.sum + this.price;
	}
	this.total = this.sum
	this.invoice_data['total'] = this.total
	this.invoice.push(this.total)
	// this.invoice.push(this.invoice_data)
  }
}
</script>

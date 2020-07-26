<template>
  <v-row>
    <v-col cols="12">
      <data-table-wrapper
        :items="tickets"
        :headers="headers"
        with-search
        sort-by="requested_to_cancel_cancel"
      >
        <template #item="{ item }">
          <tr>
            <td>
              {{ item.id }}
            </td>
            <td>{{ item.status == 0 ? 'Not Booked' : 'Booked' }}</td>
            <!-- <td>{{ item.trip.id }}</td>
            <td>{{ item.route.from }}</td>
            <td>{{ item.route.to }}</td>
            <td>{{ item.created_at }}</td>
            <td>{{ item.price }}</td>
            <td>{{ item.route.duration }}</td> -->
            <td>{{ item.requested_to_cancel_cancel == 1 ? 'Yes' : 'No'}}</td>

            <td class="text-right">

              <template v-if="item.deleted_at">
                <v-chip color="warning" outlined>Deleted</v-chip>
              </template>

              <v-btn text icon @click="edit(item)">
                <v-icon>edit</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>

      </data-table-wrapper>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo: { title: 'tickets' },

  layout: (h, page) => h(Layout, [page]),

  props: {
    tickets: Array,
  },

  data: vm => ({
    headers: [
      {text: 'ID', value: 'id'},
      {text: 'Status', value: 'status'},
      // {text: 'Trip Number', value: 'trip.id'},
      // {text: 'From', value: 'route.from'},
      // {text: 'To', value: 'route.to'},
      // {text: 'Date', value: 'created_at'},
      // {text: 'Price', value: 'price'},
      // {text: 'Trip Duration', value: 'route.duration'},
      // {text: 'Weight', value: 'trip.weight'},
      {text: 'requested', value: 'requested_to_cancel_cancel'},
      {text: '', sortable: false},
    ],
  }),

  methods: {
    edit(_ticket) {
      console.log(_ticket)
      this.$inertia.put(route('ticket_update', _ticket.id))
    },
  },
}
</script>

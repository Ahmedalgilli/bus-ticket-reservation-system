<template>
  <v-row>
    <v-col cols="12">
      <data-table-wrapper
        :items="trips"
        :headers="headers"
        with-search
        sort-by="name"
      >
        <template #item="{ item }">
          <tr>
            <td>
              {{ item.id }}
            </td>
            <td>{{ item.from }}</td>
            <td>{{ item.to }}</td>
            <td>{{ item.date }}</td>
            <td>
              {{ item.price }}
            </td>
            <td>{{ item.seats_number }}</td>
            <!-- <td>{{ item.trip_duration }}</td> -->
            <td>{{ item.weight }}</td>
            <td>{{ item.number_of_tikcets }}</td>
            <td>{{ item.available_tikcets }}</td>
            <td>{{ item.booked_tikcets }}</td>

            <td class="text-right">

              <template v-if="item.deleted_at">
                <v-chip color="warning" outlined>Deleted</v-chip>
              </template>

              <v-btn text icon color="info" @click="show(item.id)">
                <v-icon>eye</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>

      </data-table-wrapper>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/ManagerLayout'

export default {
  metaInfo: { title: 'Managers-Trips' },

  layout: (h, page) => h(Layout, [page]),

  props: {
    trips: Array,
  },

  data: vm => ({
    headers: [
      {text: 'ID', value: 'id'},
      {text: 'From', value: 'from'},
      {text: 'To', value: 'to'},
      {text: 'Date', value: 'date'},
      {text: 'Price', value: 'price'},
      {text: 'Seats Number', value: 'seats_number'},
      // {text: 'Trip Duration', value: 'trip_duration'},
      {text: 'Weight', value: 'weight'},
      {text: 'Tickets', value: 'number_of_tikcets'},
      {text: 'Available', value: 'available_tikcets'},
      {text: 'Booked', value: 'booked_tikcets'},
      {text: '', sortable: false},
    ],
  }),

  methods: {
    show(_trips) {
      this.$inertia.visit(route('tickets.index', _trips))
    },
  },
}
</script>

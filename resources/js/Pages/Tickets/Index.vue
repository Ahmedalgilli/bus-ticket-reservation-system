<template>
  <v-row>
    <!-- <v-col cols="12" class="py-0" v-show="this.$inertia.page.props.auth.role == 'employee'">
      <v-row justify="end" dense>
        <v-col cols="auto" class="py-0">
          <v-btn @click="create" color="primary">Create Ticket</v-btn>
        </v-col>
      </v-row>
    </v-col> -->

    <v-col cols="12">
      <data-table-wrapper
        :items="tickets"
        :headers="headers"
        with-search
        sort-by="name"
      >
        <template #item="{ item }">
          <tr>
            <td>
              {{ item.id }}
            </td>
            <td>{{ item.status == 0 ? 'Not Booked' : 'Booked' }}</td>
            <td>{{ item.trip.id }}</td>
            <td>{{ item.route.from }}</td>
            <td>{{ item.route.to }}</td>
            <td>{{ item.created_at }}</td>
            <td>{{ item.price }}</td>
            <td>{{ item.route.duration }}</td>
            <td>{{ item.trip.weight }}</td>

            <td class="text-right">

              <template v-if="item.deleted_at">
                <v-chip color="warning" outlined>Deleted</v-chip>
              </template>

              <v-btn text icon @click="edit(item.id)">
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
      {text: 'Trip Number', value: 'trip.id'},
      {text: 'From', value: 'route.from'},
      {text: 'To', value: 'route.to'},
      {text: 'Date', value: 'created_at'},
      {text: 'Price', value: 'price'},
      {text: 'Trip Duration', value: 'route.duration'},
      {text: 'Weight', value: 'trip.weight'},
      {text: '', sortable: false},
    ],
  }),

  methods: {
    create() {
      this.$inertia.visit(route('tickets.create'))
    },
    edit(_tickets) {
      this.$inertia.visit(route('tickets.edit', _tickets))
    },
  },
}
</script>

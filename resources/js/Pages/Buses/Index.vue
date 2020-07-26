<template>
  <v-row>
    <v-col cols="12" class="py-0">
      <v-row justify="end" dense>
        <v-col cols="auto" class="py-0">
          <v-btn v-show="$inertia.page.props.auth.user.role == 'employee'" @click="create" color="primary">Create Bus</v-btn>
        </v-col>
      </v-row>
    </v-col>

    <v-col cols="12">
      <data-table-wrapper
        :items="buses"
        :headers="headers"
        with-search
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
            <td>{{ item.license_plate_number }}</td>
            <td>{{ item.seats_number }}</td>

            <td class="text-right">

              <template v-if="item.deleted_at">
                <v-chip color="warning" outlined>Deleted</v-chip>
              </template>

              <v-btn text icon @click="edit(item.id)" v-show="$inertia.page.props.auth.user.role == 'employee'">
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
  metaInfo: { title: 'Buses' },

  layout: (h, page) => h(Layout, [page]),

  props: {
    buses: Array,
  },

  data: vm => ({
    headers: [
      {text: 'ID', value: 'id'},
      {text: 'Name', value: 'name'},
      {text: 'License Plate Number', value: 'license_plate_number'},
      {text: 'Seats Number', value: 'seats_number'},
      {text: '', sortable: false},
    ],
  }),

  methods: {
    create() {
      this.$inertia.visit(route('buses.create'))
    },
    edit(_buses) {
      this.$inertia.visit(route('buses.edit', _buses))
    },
  }
}
</script>

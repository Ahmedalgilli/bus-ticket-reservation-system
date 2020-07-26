<template>
  <v-row>
    <v-col cols="12" class="py-0">
      <v-row justify="end" dense>
        <v-col cols="auto" class="py-0">
          <v-btn v-show="$inertia.page.props.auth.user.role == 'employee'" @click="create" color="primary">Create Route</v-btn>
        </v-col>
      </v-row>
    </v-col>

    <v-col cols="12">
      <data-table-wrapper
        :items="Routes"
        :headers="headers"
        with-search
        sort-by="from"
      >
        <template #item="{ item }">
          <tr>
            <td>
              {{ item.id }}
            </td>
            <td>
              {{ item.from }}
            </td>
            <td>{{ item.to }}</td>
            <td>{{ item.duration }}</td>

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
  metaInfo: { title: 'Routes' },

  layout: (h, page) => h(Layout, [page]),

  props: {
    Routes: Array,
  },

  data: vm => ({
    headers: [
      {text: 'ID', value: 'id'},
      {text: 'From', value: 'from'},
      {text: 'To', value: 'to'},
      {text: 'Duration', value: 'duration'},
      {text: '', sortable: false},
    ],
  }),

  methods: {
    create() {
      this.$inertia.visit(route('routes.create'))
    },
    edit(_routes) {
      this.$inertia.visit(route('routes.edit', _routes))
    },
  }
}
</script>

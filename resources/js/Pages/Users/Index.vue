<template>
  <v-row>
    <v-col cols="12" class="py-0">
      <v-row justify="end" dense>
        <v-col cols="auto" class="py-0">
          <v-btn @click="create" color="primary">Create Manager</v-btn>
        </v-col>
      </v-row>
    </v-col>

    <v-col cols="12">
      <data-table-wrapper
        :items="users"
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
              {{ item.first_name }}
            </td>
            <td>
              {{ item.last_name }}
            </td>
            <td>
              {{ item.email }}
            </td>
            <td>
              {{ item.role == undefined ? '' : item.role.name }}
            </td>
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
import Layout from '@shared/Layout'

export default {
  metaInfo: { title: 'Users' },

  layout: (h, page) => h(Layout, [page]),

  props: {
    users: Array,
  },

  data: vm => ({
    headers: [
      {text: 'ID', value: 'id'},
      {text: 'First Name', value: 'first_name'},
      {text: 'Last Name', value: 'last_name'},
      {text: 'Email', value: 'email'},
      {text: 'Role', value: 'role.name'},
      {text: '', sortable: false},
    ],
  }),

  methods: {
    create() {
      this.$inertia.visit(route('admin.users.create'))
    },
    edit(_users) {
      this.$inertia.visit(route('admin.users.edit', _users))
    },
  },
  created(){
    // this.users.map(user => {
    //   user.role_name = user.role.name
    // })
    console.log(this.users)
  }
}
</script>

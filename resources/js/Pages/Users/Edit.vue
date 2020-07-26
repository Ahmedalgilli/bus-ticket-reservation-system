<template>
  <v-row>
    <v-col cols="12" v-if="user.deleted_at">
      <trashed-banner @restore="restore">
        This user has been deleted.
      </trashed-banner>
    </v-col>

    <v-col cols="12">
      <user-form v-bind:form.sync="form"></user-form>
    </v-col>

    <v-col cols="12" class="py-0">
      <v-btn v-if="!user.deleted_at" color="warning" @click="destroy">Delete User</v-btn>
      <v-btn :loading="sending" color="primary" @click="submit">Update User</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/Layout'

export default {
  metaInfo() {
    return {
      title: this.user.name,
      goBack: {
        title: 'Users',
        url: 'admin.users.index',
      }
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props: {
    user: Object,
    roles: Array,
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      ...vm.user
    },
  }),

  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('admin.users.update', this.user.id), this.form)
        .then(() => this.sending = false)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete(this.route('admin.users.destroy', this.user.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this user?')) {
        this.$inertia.put(this.route('admin.users.restore', this.user.id))
      }
    },
  },
  created(){
    this.rolesData = this.roles.map(role => {
      return { value : role.id, text : role.name }
    })
    this.form.roles = this.rolesData
  }
}
</script>

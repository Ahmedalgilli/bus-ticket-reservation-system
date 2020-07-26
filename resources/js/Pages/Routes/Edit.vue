<template>
  <v-row>
    <v-col cols="12" v-if="route.deleted_at">
      <trashed-banner @restore="restore">
        This route has been deleted.
      </trashed-banner>
    </v-col>

    <v-col cols="12">
      <route-form v-bind:form.sync="form"></route-form>
    </v-col>

    <v-col cols="12" class="py-0">
      <v-btn v-if="!route.deleted_at" color="warning" @click="destroy">Delete Route</v-btn>
      <v-btn :loading="sending" color="primary" @click="submit">Update Route</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo() {
    return {
      title: `${this.route.from} - ${this.route.to}`,
      goBack: {
        title: 'Routes',
        url: 'routes.index',
      }
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props: {
    _route: Object,
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      ...vm._route
    },
  }),

  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('routes.update', this._route.id), this.form)
        .then(() => this.sending = false)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this route?')) {
        this.$inertia.delete(this.route('routes.destroy', this._route.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this route?')) {
        this.$inertia.put(this.route('routes.restore', this._route.id))
      }
    },
  },
}
</script>

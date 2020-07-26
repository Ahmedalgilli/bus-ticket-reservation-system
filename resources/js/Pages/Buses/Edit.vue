<template>
  <v-row>
    <v-col cols="12" v-if="bus.deleted_at">
      <trashed-banner @restore="restore">
        This bus has been deleted.
      </trashed-banner>
    </v-col>

    <v-col cols="12">
      <bus-form v-bind:form.sync="form"></bus-form>
    </v-col>

    <v-col cols="12" class="py-0">
      <v-btn v-if="!bus.deleted_at" color="warning" @click="destroy">Delete Bus</v-btn>
      <v-btn :loading="sending" color="primary" @click="submit">Update Bus</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'

export default {
  metaInfo() {
    return {
      title: this.bus.name,
      goBack: {
        title: 'Buses',
        url: 'buses.index',
      }
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props: {
    bus: Object,
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      ...vm.bus
    },
  }),

  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('buses.update', this.bus.id), this.form)
        .then(() => this.sending = false)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this bus?')) {
        this.$inertia.delete(this.route('buses.destroy', this.bus.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this bus?')) {
        this.$inertia.put(this.route('buses.restore', this.bus.id))
      }
    },
  },
}
</script>

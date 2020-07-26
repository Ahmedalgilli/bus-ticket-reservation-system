<template>
  <v-row>
    <v-col cols="12" v-if="employee.deleted_at">
      <trashed-banner @restore="restore">
        This employee has been deleted.
      </trashed-banner>
    </v-col>

    <v-col cols="12">
      <employee-form v-bind:form.sync="form"></employee-form>
    </v-col>

    <v-col cols="12" class="py-0">
      <v-btn v-if="!employee.deleted_at" color="warning" @click="destroy">Delete Employee</v-btn>
      <v-btn :loading="sending" color="primary" @click="submit">Update Employee</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/ManagerLayout'

export default {
  metaInfo() {
    return {
      title: this.employee.first_name + ' ' + this.employee.last_name,
      goBack: {
        title: 'Employees',
        url: 'managers.employees.index',
      }
    }
  },

  layout: (h, page) => h(Layout, [page]),

  props: {
    employee: Object,
    roles: Array,
  },

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      ...vm.employee
    },
  }),

  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('managers.employees.update', this.employee.id), this.form)
        .then(() => this.sending = false)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this employee?')) {
        this.$inertia.delete(this.route('managers.employees.destroy', this.employee.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this employee?')) {
        this.$inertia.put(this.route('managers.employees.restore', this.employee.id))
      }
    },
  },
  created(){
    console.log(this.employee)
  }
}
</script>

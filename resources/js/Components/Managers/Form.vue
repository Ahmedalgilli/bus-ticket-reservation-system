<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.first_name"
          :error-messages="$page.errors.first_name"
          label="First Name"
          type="text"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.last_name"
          :error-messages="$page.errors.last_name"
          label="Last Name"
          type="text"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.email"
          :error-messages="$page.errors.email"
          label="Email"
          type="text"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.password"
          :error-messages="$page.errors.password"
          label="Password"
          type="password"
          outlined
        ></v-text-field>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
  export default {
    name: 'EmployeeForm',

    props: {
      form: Object,
    },

    data: vm => ({
    }),
    methods: {
    },
    created(){
      console.log(this.form)
    }
  }
</script>
<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.name"
          :error-messages="$page.errors.name"
          label="Passenger Name"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.phone"
          :error-messages="$page.errors.phone"
          label="Passenger Phone Number"
          outlined
        ></v-text-field>
      </v-col>
      
    </v-row>
  </v-form>
</template>

<script>
  export default {
    name: 'StepForm',

    props: {
      form: Object,
    },

    data: vm => ({
    })
  }
</script>
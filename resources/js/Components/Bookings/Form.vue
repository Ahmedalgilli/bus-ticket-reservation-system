<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="12" lg="12">
        <v-text-field
          v-model="form.tickets_number"
          :error-messages="$page.errors.tickets_number"
          label="Tickets Number"
          outlined
        ></v-text-field>
      </v-col>
      <!-- <v-col cols="12" lg="12">
        <v-text-field
          v-model="form.name"
          :error-messages="$page.errors.name"
          label="Name"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="12">
        <v-text-field
          v-model="form.phone"
          :error-messages="$page.errors.phone"
          label="Phone Number"
          outlined
        ></v-text-field>
      </v-col> -->
      <!-- <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.seats_number"
          :error-messages="$page.errors.seats_number"
          label="Seats Number"
          outlined
        ></v-text-field>
      </v-col> -->
    </v-row>
  </v-form>
</template>

<script>
  export default {
    name: 'BookingForm',

    props: {
      form: Object
    },

    data: vm => ({
    })
  }
</script>
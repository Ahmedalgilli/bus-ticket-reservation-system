<template>
  <v-row>
    <!-- <v-col cols="12">
        <h1>Please Enter The Number Of tickets That You Wants And Prase Continue</h1>
    </v-col>

    <v-col cols="12">
      <booking-form v-bind:form.sync="form"></booking-form>
    </v-col>

    <v-col cols="12">
      <v-btn :loading="sending" color="primary" @click="submit">Continue</v-btn>
    </v-col> -->
    <v-col cols="12">
      <StepOne />
      <!-- <BookingSteps /> -->
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/EmployeeLayout'
import StepOne from '../../Components/StepOne'
import BookingSteps from '../../Components/BookingSteps'

export default {
  components: {
    BookingSteps,
    StepOne
  },
  metaInfo: {
    title: 'Create Bus',
    goBack: {
      title: 'Buses',
      url: 'buses.index',
    }
  },

  layout: (h, page) => h(Layout, [page]),

  remember: 'form',

  data: vm => ({
    sending: false,
    form: {
      name: null,
      license_plate_number: null,
      seats_number: null,
    },
  }),
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('booking.tickets_number'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>

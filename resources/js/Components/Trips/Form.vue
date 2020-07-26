<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="12" lg="6" v-if="form.trip_route_id">
        <v-select
          v-model="form.route_id"
          :error-messages="$page.errors.route_id"
          :items="form.routes"
          label="Route"
          outlined
        ></v-select>
      </v-col>
      <v-col cols="12" lg="6" v-if="!form.trip_route_id">
        <v-select
          v-model="form.route_id"
          :error-messages="$page.errors.route_id"
          :items="form.routes"
          label="Route"
          outlined
        ></v-select>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.seats_number"
          :error-messages="$page.errors.seats_number"
          label="Seats Number"
          type="number"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.price"
          :error-messages="$page.errors.price"
          label="Price"
          type="number"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" lg="6">
        <v-select
          v-model="form.weight"
          :error-messages="$page.errors.weight"
          :items="weights"
          label="Weight"
          outlined
        ></v-select>
      </v-col>
      <v-col cols="12" lg="6">
        <v-menu
          ref="menu"
          v-model="menu"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-text-field
              v-model="form.date"
              label="Date"
              hint="MM/DD/YYYY format"
              persistent-hint
              prepend-icon="event"
              @blur="date = parseDate(form.date)"
              :error-messages="$page.errors.date"
              outlined
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker v-model="date" no-title @input="menu = false"></v-date-picker>
        </v-menu>
      </v-col>
      <v-col cols="12" lg="6">
        <v-select
          v-model="form.bus_id"
          :error-messages="$page.errors.bus_id"
          :items="form.buses"
          label="Trip Bus"
          outlined
        ></v-select>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
  export default {
    name: 'TripForm',

    props: {
      form: Object,
    },

    data: vm => ({
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      menu: false,
      data: null,
      // routes: [
      //   {value: "KHARTOUM", text: 'khartoum'},
      //   {value: "SENAR", text: 'senar'},
      //   {value: "MADANI", text: 'madani'},
      //   {value: "SHENDY", text: 'shendy'},
      // ],
      times: [
        {value: "1", text: '1 hour'},
        {value: "2", text: '2 hours'},
        {value: "3", text: '3 hours'},
        {value: "4", text: '4 hours'},
      ],
      weights: [
        {value: "1", text: '1 KG'},
        {value: "2", text: '2 KG'},
        {value: "3", text: '3 KG'},
        {value: "4", text: '4 KG'},
      ],
    }),
    computed: {
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
    },

    watch: {
      date (val) {
        this.dateFormatted = this.formatDate(this.date)
      },
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${month}/${day}/${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
    },
    created(){
      // console.log(this.form)
    }
  }
</script>
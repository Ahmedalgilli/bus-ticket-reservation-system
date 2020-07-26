<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="12" lg="6">
        <v-select
          v-model="form.from"
          :error-messages="$page.errors.from"
          :items="routes"
          label="From"
          outlined
        ></v-select>
      </v-col>
      <v-col cols="12" lg="6">
        <v-select
          v-model="form.to"
          :error-messages="$page.errors.to"
          :items="routes"
          label="To"
          outlined
        ></v-select>
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.duration"
          :error-messages="$page.errors.duration"
          label="Duration"
          outlined
        ></v-text-field>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
  export default {
    name: 'RouteForm',

    props: {
      form: Object
    },

    data: vm => ({
      routes: [
        {value: "KHARTOUM", text: 'KHARTOUM'},
        {value: "SENAR", text: 'SENAR'},
        {value: "MADANI", text: 'MADANI'},
        {value: "SHENDY", text: 'SHENDY'},
      ],
    })
  }
</script>
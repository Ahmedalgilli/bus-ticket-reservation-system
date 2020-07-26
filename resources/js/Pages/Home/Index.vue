<template>
    <div class="ma-4">
        <v-row class="ma-5">
          <v-col cols="4" lg="4" sm="12">
            <v-spacer></v-spacer>
            <v-select
              v-model="selectedFrom"
              :items="routes_from"
              label="From"
              @change="filterRoutes(selectedFrom)"
              offset-y
              outlined
              dense
            ></v-select>
            <v-spacer></v-spacer>
          </v-col>
          <v-col cols="4" lg="4" sm="12">
            <v-spacer></v-spacer>
            <v-select
              v-model="selectedTo"
              :items="routes_to"
              label="To"
              @change="filterRoutes(selectedTo)"
              offset-y
              outlined
              dense
            ></v-select>
            <v-spacer></v-spacer>
          </v-col>
          <v-col cols="4" lg="4" sm="12">
            <v-spacer></v-spacer>
              <v-menu
                  ref="menu1"
                  v-model="menu1"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
              >
                  <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                          v-model="dateFormatted"
                          label="Select The Date"
                          hint="MM/DD/YYYY format"
                          persistent-hint
                          prepend-icon="event"
                          v-bind="attrs"
                          @blur="date = parseDate(dateFormatted)"
                          v-on="on"
                      ></v-text-field>
                  </template>
                  <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
              </v-menu>
            <v-spacer></v-spacer>
          </v-col>
        </v-row>
        <v-row v-show="selectedFrom && selectedTo && selectedDate">
          <v-spacer></v-spacer>
          <v-btn :loading="sending" color="primary" @click="submit" >Search</v-btn>
          <v-spacer></v-spacer>
            <!-- <v-col v-for="_route in data" :key="_route.id" cols="12" lg="3">
                <RouteList :_route="_route" />
            </v-col> -->
        </v-row>
    </div>
</template>

<script>
import BaseLayout from '@shared/BaseLayout'
import RouteList from '../../Components/Shared/RouteList'
import DatePickerInput from '../../Components/DatePickerInput'

export default {
  name: "Home",
  metaInfo: {
    title: 'Routes Page'
  },

  layout: (h, page) => h(BaseLayout, [page]),
  props: {
    routes: Array
  },
  data(vm) {
    return {
      sending: null,
      selectedFrom: null,
      selectedTo: null,
      selectedDate: null,
      selectData: [],
      data: [],
      form: {},
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      menu1: false,
    }
  },
  methods: {
    submit(){
      this.sending = true
      this.form.from = this.selectedFrom
      this.form.to = this.selectedTo
      this.form.date = this.dateFormatted
      this.sending = false
      this.$inertia.post(route('search'), this.form)
    },
    filterRoutes(item){
      console.log(this.dateFormatted)
      this.data = this.routes.filter(_route => {
        if(item == 'all'){
          return _route.id != item;
        }else{
          return _route.id == item;
        }
      })
    },
    formatDate (date) {
      if (!date) return null
      this.selectedDate = true

      const [year, month, day] = date.split('-')
      return `${month}/${day}/${year}`
    },
    parseDate (date) {
      if (!date) return null
      
      const [month, day, year] = date.split('/')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
  },
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
  created(){
    this.routes_from = this.routes.map(_route => {
      return { value : _route.from, text : _route.from }
    })
    this.routes_to = this.routes.map(_route => {
      return { value : _route.to, text : _route.to }
    })
    // this.routes_from.unshift({
    //   value: 'all', text: 'All Routes'
    // })
    // this.routes_to.unshift({
    //   value: 'all', text: 'All Routes'
    // })
    this.data = this.routes
  }
}
</script>

<template>
    <div>
        <v-row class="ma-5">
            <v-col cols="12" lg="12">
                <v-spacer></v-spacer>
                <v-select
                    v-model="selectedRoute"
                    :items="selectData"
                    label="Select Route"
                    @change="filterRoutes(selectedRoute)"
                    offset-y
                    outlined
                    dense
                ></v-select>
                <v-spacer></v-spacer>
            </v-col>
        </v-row>
        <v-row class="ma-2">
            <v-col v-for="_route in data" :key="_route.id" cols="12" lg="3">
                <RouteList :_route="_route" />
            </v-col>
        </v-row>
    </div>
</template>

<script>
import Layout from '@shared/EmployeeLayout'
import RouteList from '../../Components/Shared/RouteList'

export default {
  name: "Home",
  props: {
    routes: Array
  },
  metaInfo: {
      title: 'Step One',
      goBack: {
      title: 'Booking',
      url: 'booking',
      }
  },

  layout: (h, page) => h(Layout, [page]),
  data() {
    return {
      selectedRoute: null,
      selectData: [],
      data: []
    }
  },
  computed: {
  },
  methods: {
    filterRoutes(item){
      this.data = this.routes.filter(_route => {
        if(item == 'all'){
          return _route.id != item;
        }else{
          return _route.id == item;
        }
      })
    }
  },
  created(){
    this.selectData = this.routes.map(_route => {
      return { value : _route.id, text : _route.name }
    })
    this.selectData.unshift({
      value: 'all', text: 'All Routes'
    })
    this.data = this.routes
  }
}
</script>

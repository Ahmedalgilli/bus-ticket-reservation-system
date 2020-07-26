<template>
  <v-card
  >
    <!-- class="mx-auto" -->
    <!-- max-width="" -->
    <v-card-title>
        <v-spacer></v-spacer>
            <div class="overline mb-4"><h3>{{ _route.name }}</h3></div>
        <v-spacer></v-spacer>
    </v-card-title>
    <v-card-text>
        <v-card outlined>
            <v-card-title>
                <v-spacer></v-spacer>
                <div class="overline mb-4">{{ 'Number Of Trips ' + _route.allTrips.length }}</div>
                <v-spacer></v-spacer>
        </v-card-title>
        </v-card>
    </v-card-text>
    <v-card-actions>
        <v-spacer></v-spacer>
        <!-- <vs-button
            shadow
            :active="active == 0"
            @click="submit(_route.id)"
        >View All Trips </vs-button> -->
        <v-btn :loading="sending" color="primary" @click="submit(_route.id)">View All Trips</v-btn>
        <v-spacer></v-spacer>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
    name: "RouteList",
    props: {
        _route: Object
    },
    data() {
        return {
            sending: false,
            active: 0
        }
    },
    methods: {
        showTrips(){

        },
        submit(id) {
            // this.active = 1
            this.sending = true
            this.$inertia.visit(this.route('routes.show', id))
        },
    },
    created(){
        // console.log(this._route)  
    } 
}
</script>
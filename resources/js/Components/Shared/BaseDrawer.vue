<template>
    <v-navigation-drawer
      absolute
      temporary
      height="auto"
      v-model="$root.baseDrawer" app
    >
      <v-list class="pt-0" dense>
          <v-list-item 
          v-for="item in items"
                :key="item.title" 
          link @click="$inertia.visit(route(item.route))" value="/">
          <v-list-item-content>
            <v-list-item-title>
            {{ item.title }}
            </v-list-item-title>
          </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
      </v-list>
    </v-navigation-drawer>
</template>
<script>
  export default {
    name: 'BaseDrawer',
    data: vm => ({
        items: [
          { title: 'Home', icon: 'dashboard', route: 'landing' },
          { title: 'Pay', icon: 'dashboard', route: 'trips.bookings.pay' },
          { title: 'Cansel Ticket', icon: 'dashboard', route: 'trips.tickets_cancel_request' },
          { title: 'Aboute', icon: 'dashboard', route: 'about' },
        //   { title: 'About', icon: 'question_answer', route: 'aboute' }
        ]
    }),
    computed: {
      currentController() {
        const controller = location.pathname.substr(1).split('/').shift()
        return `/${controller}`
      }
    },
  }
</script>
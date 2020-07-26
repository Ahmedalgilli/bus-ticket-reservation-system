<template>
  <v-toolbar color="grey">
	<v-app-bar-nav-icon @click.stop="$root.baseDrawer = !$root.baseDrawer" class="d-flex d-sm-none"/>
    <inertia-link href="/landing">
        <v-toolbar-title class="white--text">UOFK BTRS</v-toolbar-title>
    </inertia-link>
    <v-spacer></v-spacer>
    <div class="hidden-sm-and-down">
		<inertia-link href="/landing">
			<v-btn text large>Home</v-btn>
		</inertia-link>
		<inertia-link href="/bookings/pay">
			<v-btn text large>Pay</v-btn>
		</inertia-link>
		<inertia-link href="/bookings/cancel">
			<v-btn text large>Cancel Ticket</v-btn>
		</inertia-link>
		<inertia-link href="/about">
			<v-btn text large>About</v-btn>
		</inertia-link>
    </div>
  </v-toolbar>
</template>

<script>
  export default {
    data () {
      return {
        // drawer: null,
        items: [
          { title: 'Home', icon: 'dashboard', route: 'landing' },
        //   { title: 'About', icon: 'question_answer', route: 'aboute' }
        ]
      }
    }
  }
</script>
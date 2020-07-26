<template>
  <v-app-bar app>
    <v-app-bar-nav-icon @click.stop="$root.managerDrawer = !$root.managerDrawer" />
    <v-toolbar-title>
      <template v-if="$root.goBack">
        <inertia-link class="light-blue--text lighten-5--text" :href="route($root.goBack.url)">
          {{$root.goBack.title}}
        </inertia-link>
        /
      </template>
      <!-- {{$root.appTitle}} -->
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <inertia-link href="/managers/employees">
			<v-btn text>Employees</v-btn>
		</inertia-link>
  </v-app-bar>
</template>

<script>
  export default {
    name: 'ManagerBar',
    created(){
      this.auth = this.$inertia.page.props.auth.user;
      // console.log(this.$inertia.page.props.auth.role)
      if(this.auth.role == 'admin'){
        console.log('admin')
      }else{
        console.log('manger')
      }
    }
  }
</script>

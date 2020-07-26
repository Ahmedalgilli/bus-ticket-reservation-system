<template>
  <v-app id="landing">
    <BaseDrawer />
    <AppToolbar />
    <v-content>
      <v-container fluid scroll-region>
        <flash-messages></flash-messages>
        <slot/>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import BaseDrawer from '../Shared/BaseDrawer'
import AppToolbar from '../AppToolbar'
export default {
  name: "BaseLayout",
  data() {
    return {}
  },
  computed: {
  },
  methods: {
    // url() {
    //   return location.pathname.substr(1)
    // },
    // hideDropdownMenus() {
    //   this.showUserMenu = false
    // },
  },
}
</script>

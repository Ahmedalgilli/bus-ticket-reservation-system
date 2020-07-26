<template>
  <v-container>
    <v-row justify="center">
      <v-col
        cols="12"
        md="2"
      >
      Landing
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import BaseLayout from '@shared/BaseLayout'

export default {
  metaInfo: {
    title: 'Landing Page'
  },

  layout: (h, page) => h(BaseLayout, [page]),

  // remember: 'form',

  data: vm => ({
  }),
  methods: {
  },
}
</script>

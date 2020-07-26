<template>
  <v-row>
    <v-col cols="12">
      <h1>Dashboard</h1>
    </v-col>

    <v-col cols="12">
      <v-row>
        <v-col cols="12">
          <v-card>
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">Managers</h3>
              </div>
            </v-card-title>
            <v-card-text>
              {{ users.length }}
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  props: {
    users: Array
  },
  layout: (h, page) => h(Layout, [page]),
}
</script>

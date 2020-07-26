<template>
  <v-row>

    <v-col cols="12">
      <h1>Manager Dashboard</h1>
    </v-col>

    <v-col cols="12">
      <v-row>
        <v-col cols="6">
          <v-card>
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">Employees</h3>
              </div>
            </v-card-title>
            <v-card-text>
              {{ employees.length }}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card>
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">Routes</h3>
              </div>
            </v-card-title>
            <v-card-text>
              {{ routes.length }}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card>
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">Trips</h3>
              </div>
            </v-card-title>
            <v-card-text>
              {{ trips.length }}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card>
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">Buses</h3>
              </div>
            </v-card-title>
            <v-card-text>
              {{ buses.length }}
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-col>

  </v-row>
</template>

<script>
import Layout from '@shared/ManagerLayout'

export default {
  metaInfo: { title: 'Employee Dashboard' },
   props: {
    'employees' : Array,
    'buses' : Array,
    'routes' : Array,
    'trips' : Array,
  },
  layout: (h, page) => h(Layout, [page]),
  created(){
      // console.log(this.page)
      // console.log($inertia.page.user.role)
    }
}
</script>

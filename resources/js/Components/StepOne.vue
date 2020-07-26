<template>
  <v-card
    class="mx-auto mb-3"
    dark
  >

    <v-row
      class="px-2 pb-2 ma-0"
      justify="space-between"
      v-for="(row,i) in rows"
      :key="i"
    >
      <v-btn-toggle
        v-model="formatting"
        multiple
      >

        <!-- <v-row v-show="row.length != rowThree.length" dense> -->
        <v-row dense>
          <v-col
          v-for="i in row"
          :key="i"
          class="title grey--text font-weight-regular text--darken-2 ma-4"
          >
          <v-btn @click="add(i)" color="info">{{ i }}</v-btn></v-col>
        </v-row>

      </v-btn-toggle>

    </v-row>

    <v-btn
      color="primary"
      @click="submit"
      class="ma-4"
    >
      Continue
    </v-btn>

    <v-btn class="ma-4" text>Cancel</v-btn>

  </v-card>
</template>

<script>
  export default {
    data: () => ({
      alignment: 1,
      formatting: [],
      rows: [],
      rowOne: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 41],
      rowTow: [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 42],
      rowThree: [43],
      rowFour: [21, 23, 25, 27, 29, 31, 33, 35, 37, 39, 44],
      rowFive: [22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 45],
      seats: [],
    }),
    methods: {
      add(i){
        if(this.seats.includes(i)){
          this.remove(i)
        }else{
          this.seats.push(i)
        }
          console.log(this.seats)
      },
      remove(i){
        const index = this.seats.indexOf(i);
        if (index > -1) {
          this.seats.splice(index, 1);
        }
      },
      submit(){
        this.sending = true
        this.$inertia.post(this.route('booking.step_one'), this.seats)
          .then((response) => { 
            this.sending = false
            this.stepNumber = respone.data
            // this.stepNumber = step_tow
          })
      }
    },
    created(){
        this.rows = [this.rowOne, this.rowTow, this.rowThree, this.rowFour, this.rowFive]
    }
  }
</script>
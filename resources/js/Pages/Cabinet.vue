<template>
  <NavLayout currentPage="cabinet"/>
  <div class="block-cabinet">
    <img class="head" :src="`/head/${userData.nickname}.png`">
  </div>
</template>
  
<script>
  import NavLayout from '../Layouts/Navbar.vue'
  import { Link, router } from '@inertiajs/vue3'
  export default {
    components: {
      NavLayout,
    },
    data() {
      return {

      };
    },
    props: [
      'userData'
    ],
    created() {

    },
    methods: {

    },
    mounted() {

    }
  };
</script>
  
<template>
  <p>Hello</p>  
  <NavLayout currentPage="cabinet"/>
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

    ],
    created() {

    },
    methods: {

    },
    mounted() {

    }
  };
</script>
  
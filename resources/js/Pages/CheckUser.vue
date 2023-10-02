<template>
  <div class="lds-ripple"><div></div><div></div></div>
</template>



<style>
.lds-ripple {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
  top: calc(var(--tg-viewport-height)/2 - 50px);
}
.lds-ripple div {
  position: absolute;
  border: 4px solid var(--tg-theme-text-color);
  opacity: 1;
  border-radius: 50%;
  animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes lds-ripple {
  0% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 0;
  }
  4.9% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 0;
  }
  5% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 0px;
    left: 0px;
    width: 72px;
    height: 72px;
    opacity: 0;
  }
}
</style>
<script>
  import { Link, router } from '@inertiajs/vue3'
  export default {
    data() {
      return {

      };
    },
    created() {

    },
    methods: {

    },
    mounted() {
        var tg = window.Telegram.WebApp;
        var url_query = new URLSearchParams(tg.initData);
        var query = url_query.get("query_id");
        var user = url_query.get("user");
        var date = url_query.get("auth_date");
        var hash = url_query.get("hash");
        router.get(`/webapp/cabinet?query_id=${query}&user=${user}&auth_date=${date}&hash=${hash}`);
   
    }
  };
</script>
  
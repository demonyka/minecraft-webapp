  <script>
  export default {
    mounted() {
        Telegram.WebApp.showPopup({
                message: 'Ошибка авторизации',
                buttons: [
                    {id: 'close', type: 'close'},
                ]
            }, function(buttonId) {
                if (buttonId === 'close') {
                    window.Telegram.WebApp.close();
                }
            });
        }
  };
  </script>
  
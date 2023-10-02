<template>
  <div class="block-registration">
    <h2 style="margin: 0 0 10px;">Регистрация</h2>
    <div class="block-input">
      <label for="nickname_input" id="reg_nickname">Ваш никнейм</label>
      <input id="nickname_input" @focus="MoveLabel('reg_nickname', '-20px', '14px'); clearError('nickname_input', 'reg_nickname')" @focusout="checkNicknameAvailability(reg_nickname); reg_nickname ? false : MoveLabel('reg_nickname', '0', '16px');" v-model.trim="reg_nickname" type="text">
    </div>
    <div class="block-input">
      <label for="email_input" id="reg_email">Ваш адрес эл. почты</label>
      <input id="email_input" @focus="MoveLabel('reg_email', '-20px', '14px'); clearError('email_input', 'reg_email')" @focusout="checkEmailAvailability(reg_email); reg_email ? false : MoveLabel('reg_email', '0', '16px');" v-model.trim="reg_email" type="text">
    </div>
    <div class="block-input">
      <label for="password_input" id="reg_password">Введите пароль</label>
      <input id="password_input" @focus="MoveLabel('reg_password', '-20px', '14px'); clearError('password_input', 'reg_password')" @focusout="checkPassword(reg_password); reg_password ? false : MoveLabel('reg_password', '0', '16px')" v-model="reg_password" type="password">
    </div>
    <div class="block-input">
      <label for="password_confirm_input" id="reg_password_confirm">Повторите пароль</label>
      <input id="password_confirm_input" @focus="MoveLabel('reg_password_confirm', '-20px', '14px'); clearError('password_confirm_input', 'reg_password_confirm')" @focusout="checkPasswordConfirm(reg_password_confirm); reg_password_confirm ? false : MoveLabel('reg_password_confirm', '0', '16px')" v-model="reg_password_confirm" type="password">
    </div>
    <div class="block-input">
      <label for="referal_input" id="reg_referal">Кто вас пригласил?</label>
      <input @keyup.enter="(nickname_correct == true && email_correct == true && password_correct == true && password_confirm_correct == true) ? generateRegistrationLink() : false" id="referal_input" @focus="MoveLabel('reg_referal', '-20px', '14px'); clearError('referal_input', 'reg_referal')" @focusout="reg_referal ? false : MoveLabel('reg_referal', '0', '16px')" v-model.trim="reg_referal" type="text">
    </div>
    <div class="block-button">
      <a 
        v-if="nickname_correct == true && email_correct == true && password_correct == true && password_confirm_correct == true"
        @click="generateRegistrationLink()"
        class="a-button">
        Зарегистрироваться
    </a>
      <a v-else class="a-button a-button-disactive">Зарегистрироваться</a>
    </div>
    <div class="line"></div>
  </div>
  <div class="error-message" id="errorContainer">
    <h4 id="errorTitle"></h4>
    <p id="errorMessage"></p>
  </div>
</template>
<script>
  import { Link, router } from '@inertiajs/vue3'
  import MD5 from "crypto-js/md5";
  export default {
    components: {
      Link
    },
    props: [

    ],
    data() {
      return {
        reg_nickname: '',
        reg_email: '',
        reg_password: '',
        reg_password_confirm: '',
        reg_referal: '',
        nickname_correct: false,
        email_correct: false,
        password_correct: false,
        password_confirm_correct: false,
      }
    },
    computed: {

    },
    mounted() {

    },
    methods: {
      MoveLabel(label, px, font) {
        var element = document.getElementById(label);
        element.style.transform = `translateY(${px})`;
        element.style.fontSize = `${font}`;
      },
      async checkNicknameAvailability(nickname) {
        const validCharacters = /^[a-zA-Z0-9]+$/;
        if (!validCharacters.test(nickname) || nickname.length < 4 || nickname.length > 16) {
          this.showError('Некорректный никнейм', 'Допустимы только буквы a-zA-Z и цифры 0-9, также длина должна быть от 4 до 16 символов');
          document.getElementById('nickname_input').style.border = '1px solid red'
          document.getElementById('nickname_input').style.color = 'red'
          document.getElementById('reg_nickname').style.color = 'red'
          this.nickname_correct = false
        } else {
          try {
            const response = await axios.post('/check-nickname', { nickname });
            const isAvailable = response.data.isAvailable;

            if (!isAvailable) {
              this.showError('Некорректный никнейм', 'Пользователь с таким никнеймом уже существует');
              document.getElementById('nickname_input').style.border = '1px solid red'
              document.getElementById('nickname_input').style.color = 'red'
              document.getElementById('reg_nickname').style.color = 'red'
              this.nickname_correct = false
            } else {
              document.getElementById('nickname_input').style.border = '1px solid var(--tg-theme-hint-color)'
              document.getElementById('nickname_input').style.color = 'var(--tg-theme-text-color)'
              document.getElementById('reg_nickname').style.color = 'var(--tg-theme-hint-color)'
              this.nickname_correct = true
              this.hideError();
            }
          } catch (error) {
            console.error('Ошибка при проверке никнейма:', error);
            this.showError('Ошибка сервера', 'Попробуйте позже');
            this.nickname_correct = false
          }
        }
      },
      async checkEmailAvailability(email) {
        const validCharacters = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ ;
        if (!validCharacters.test(email) || email.length > 255) {
          this.showError('Некорректный адрес эл. почты', 'Введите свой настоящий адрес эл. почты<br>Пример: example@gmail.com');
          document.getElementById('email_input').style.border = '1px solid red'
          document.getElementById('email_input').style.color = 'red'
          document.getElementById('reg_email').style.color = 'red'
          this.email_correct = false
        } else {
          try {
            const response = await axios.post('/check-email', { email });
            const isAvailable = response.data.isAvailable;

            if (!isAvailable) {
              this.showError('Этот адрес эл. почты уже занят', 'Выберите другой адрес эл. почты');
              document.getElementById('email_input').style.border = '1px solid red'
              document.getElementById('email_input').style.color = 'red'
              document.getElementById('reg_email').style.color = 'red'
              this.email_correct = false
            } else {
              document.getElementById('email_input').style.border = '1px solid var(--tg-theme-hint-color)'
              document.getElementById('email_input').style.color = 'var(--tg-theme-text-color)'
              document.getElementById('reg_email').style.color = 'var(--tg-theme-hint-color)'
              this.email_correct = true
              this.hideError();
            }
          } catch (error) {
            console.error('Ошибка при проверке адрес эл. почты:', error);
            this.showError('Ошибка сервера', 'Попробуйте позже');
            this.email_correct = false
          }
        }
      },
      async checkPassword(password) {
        const validCharacters = /^[a-zA-Z0-9!@#$%&_-]*$/;
        if (!validCharacters.test(password) || password.length < 8 || password.length > 64) {
          this.showError('Некорректный пароль', 'Допустимы только буквы a-zA-Z, цифры 0-9 и спец. символы [!@#$%&_-], также длина должна быть от 8 до 64 символов');
          document.getElementById('password_input').style.border = '1px solid red'
          document.getElementById('password_input').style.color = 'red'
          document.getElementById('reg_password').style.color = 'red'
          this.password_correct = false
        } else {
            document.getElementById('password_input').style.border = '1px solid var(--tg-theme-hint-color)'
            document.getElementById('password_input').style.color = 'var(--tg-theme-text-color)'
            document.getElementById('reg_password').style.color = 'var(--tg-theme-hint-color)'
            this.password_correct = true
            this.hideError();
        }
      },
      async checkPasswordConfirm(password) {
        if(this.password_correct == true) {
          if (password != this.reg_password) {
            this.showError('Некорректный пароль', 'Пароли не совпадают');
            document.getElementById('password_confirm_input').style.border = '1px solid red'
            document.getElementById('password_confirm_input').style.color = 'red'
            document.getElementById('reg_password_confirm').style.color = 'red'
            this.password_confirm_correct = false
          } else {
              document.getElementById('password_confirm_input').style.border = '1px solid var(--tg-theme-hint-color)'
              document.getElementById('password_confirm_input').style.color = 'var(--tg-theme-text-color)'
              document.getElementById('reg_password_confirm').style.color = 'var(--tg-theme-hint-color)'
              this.password_confirm_correct = true
              this.hideError();
          }
        }
      },
      showError(title, message) {
        const errorContainer = document.getElementById('errorContainer');
        const errorTitle = document.getElementById('errorTitle');
        const errorMessage = document.getElementById('errorMessage');

        errorContainer.style.right = '-100%';
        setTimeout(
          () => {
            errorTitle.innerHTML = title;
            errorMessage.innerHTML = message;
            errorContainer.style.right = '0';
            setTimeout(
              () => {
                this.hideError();
              },3000
            );
          },300
        );
      },
      hideError() {
        const errorContainer = document.getElementById('errorContainer');
        errorContainer.style.right = '-100%';
      },
      async generateRegistrationLink() {
        try {
          const nickname = this.reg_referal;
          const response = await axios.post('/check-nickname', { nickname });
          const isAvailable = response.data.isAvailable;
          console.log(await axios.post('/check-nickname', { nickname }))


          var tg = window.Telegram.WebApp;
          var url_query = new URLSearchParams(tg.initData);
          var query = url_query.get("query_id");
          var user = url_query.get("user");
          var date = url_query.get("auth_date");
          var hash = url_query.get("hash");
          const params = {
            nickname: this.reg_nickname,
            email: this.reg_email,
            password: MD5(this.reg_password).toString(),
            referal: this.reg_referal,
            query_id: query,
            user: user,
            auth_date: date,
            hash: hash,
          };
          const referalInput = document.getElementById('referal_input');
          const regReferal = document.getElementById('reg_referal');

          if (!isAvailable || this.reg_referal == null || this.reg_referal == '') {
            referalInput.style.border = '1px solid var(--tg-theme-hint-color)';
            referalInput.style.color = 'var(--tg-theme-text-color)';
            regReferal.style.color = 'var(--tg-theme-hint-color)';
            this.hideError();
            return router.get('registration', params);
          } else {
            this.showError('Некорректный никнейм', 'Пользователя с таким никнеймом не существует');
            referalInput.style.border = '1px solid red';
            referalInput.style.color = 'red';
            regReferal.style.color = 'red';
            console.log(this.reg_referal);
          }
        } catch (error) {
          console.error('Ошибка при проверке ника:', error);
          this.showError('Ошибка сервера', 'Попробуйте позже');
        }
      },
      clearError(input, label) {
        document.getElementById(input).style.border = '1px solid var(--tg-theme-hint-color)';
        document.getElementById(input).style.color = 'var(--tg-theme-text-color)';
        document.getElementById(label).style.color = 'var(--tg-theme-hint-color)';     
      }
    }
  };
</script>
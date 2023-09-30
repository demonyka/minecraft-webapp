<template>
  <h2 style="margin-bottom: 10px;">Регистрация</h2>
  <div class="block-registration">
    <div class="block-input">
      <label for="nickname_input" id="reg_nickname">Ваш никнейм</label>
      <input id="nickname_input" @focus="MoveLabel('reg_nickname', '-20px', '14px')" @focusout="reg_nickname ? false : MoveLabel('reg_nickname', '0', '16px')"  v-model="reg_nickname" type="text">
    </div>
    <div class="block-input">
      <label for="email_input" id="reg_email">Ваш адрес электронной почты</label>
      <input id="email_input" @focus="MoveLabel('reg_email', '-20px', '14px')" @focusout="reg_email ? false : MoveLabel('reg_email', '0', '16px')" v-model="reg_email" type="text">
    </div>
    <div class="block-input">
      <label for="password_input" id="reg_password">Введите пароль</label>
      <input id="password_input" @focus="MoveLabel('reg_password', '-20px', '14px')" @focusout="reg_password ? false : MoveLabel('reg_password', '0', '16px')" v-model="reg_password" type="text">
    </div>
    <div class="block-input">
      <label for="passwrod_confirm_input" id="reg_password_confirm">Повторите пароль</label>
      <input id="passwrod_confirm_input" @focus="MoveLabel('reg_password_confirm', '-20px', '14px')" @focusout="reg_password_confirm ? false : MoveLabel('reg_password_confirm', '0', '16px')" v-model="reg_password_confirm" type="text">
    </div>
    <div class="block-input">
      <label for="referal_input" id="reg_referal">Кто вас пригласил?</label>
      <input id="referal_input" @focus="MoveLabel('reg_referal', '-20px', '14px')" @focusout="reg_referal ? false : MoveLabel('reg_referal', '0', '16px')" v-model="reg_referal" type="text">
    </div>
    <div class="block-button">
      <a v-if="isInputNotEmpty" class="a-button">Зарегистрироваться</a>
      <a v-else class="a-button a-button-disactive">Зарегистрироваться</a>
    </div>
  </div>
</template>
<script>
  import { Link } from '@inertiajs/vue3'
  export default {
    components: {
      Link
    },
    props: [

    ],
    data() {
      return {
        reg_nickname: null,
        reg_email: null,
        reg_password: null,
        reg_password_confirm: null,
        reg_referal: null
      }
    },
    computed: {

    },
    methods: {
      MoveLabel(label, px, font) {
        var element = document.getElementById(label);
        element.style.transform = `translateY(${px})`;
        element.style.fontSize = `${font}`;
      }
    }
  };
</script>
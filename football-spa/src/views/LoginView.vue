<script setup lang="ts">
  import { ref, computed } from 'vue';
  import { useFetch } from '@/hooks/useFetch';
  import { useAuthStore } from '@/stores/auth.ts';
  import * as EmailValidator from 'email-validator';
  import { useLoginFormErrors, type ErrorFormFields } from "@/hooks/loginFormErrors.ts";

  const email = ref('');
  const password = ref('');
  const formIsDisabled = ref(false);
  const formIsFilled = computed(() => email.value !== '' && password.value !== '');
  const formErrors = useLoginFormErrors();

  const authStore = useAuthStore();
  const { setAccessToken, setRefreshToken } = authStore;

  async function login() {
    const { status, data, error } = await useFetch('/proxy/api/auth/login', {
      method: 'POST',
      body:{
        email: email.value,
        password: password.value,
      },
    });

    if (error.value instanceof Error) {
      console.error(error.value);

      return;
    }

    if (400 === status.value && data.value.errors) {
      Object.keys(data.value.errors).forEach((field: string) => {
        console.log((field as (keyof ErrorFormFields)),(data.value.errors as (Record<string, string[]>))[field][0])
        formErrors.set((field as (keyof ErrorFormFields)), (data.value.errors as (Record<string, string[]>))[field][0]);
      });

      return;
    }

    if (200 !== status.value) {
      const errorMessage = data.value.message ?? data.value.error ?? 'Error en el servidor.';

      alert(errorMessage);

      return;
    }

    const responseData = data.value as Record<string, Record<string, string>>;
    setAccessToken(responseData.data.access_token);
    setRefreshToken(responseData.data.refresh_token);

    formIsDisabled.value = true;
  }

  function handlePasswordInput(e: Event) {
    const value = (e.target as HTMLInputElement).value;

    if (!value) {
      formErrors.set('password', 'Contraseña requerida.');
    } else {
      formErrors.set('password', null);
    }
  }

  function handleEmailInput(e: Event) {
    const value = (e.target as HTMLInputElement).value;

    if (!EmailValidator.validate(value)) {
      formErrors.set('email', 'Email inválido.');
    } else {
      formErrors.set('email', null);
    }
  }
</script>

<template>
  <main>
    <section class="form">
      <div class="form__control">
        <label for="email" class="form__label">Correo electrónico:</label>
        <span
          v-show="formErrors.hasError('email')"
          class="form__error-message"
        >
          {{ formErrors.get('email') }}
        </span>
        <input
          name="email"
          :class="[
            'form__input',
            { 'form__input--error': formErrors.hasError('email') },
            { 'form__input--disabled': formIsDisabled }
          ]"
          type="email"
          required
          :disabled="formIsDisabled"
          v-model="email"
          @input="handleEmailInput"
        />
      </div>

      <div class="form__control">
        <label for="password" class="form__label">Contraseña:</label>
        <span
          v-show="formErrors.hasError('password')"
          class="form__error-message"
        >
          {{ formErrors.get('password') }}
        </span>
        <input
          name="password"
          :class="[
            'form__input',
            { 'form__input--error': formErrors.hasError('password') },
            { 'form__input--disabled': formIsDisabled }
          ]"
          type="password"
          required
          :disabled="formIsDisabled"
          v-model="password"
          @input="handlePasswordInput"
        />
      </div>

      <br/>
      <div :class="['form__submit', { 'form__submit--disabled': formErrors.hasErrors() || !formIsFilled }]">
        <button
          :disabled="formErrors.hasErrors() || !formIsFilled"
          @click.prevent="login"
        >
          Ingresar
        </button>
      </div>
    </section>
  </main>
</template>

<style>
@media (min-width: 1024px) {
  main {
    margin-top: 2rem;
    margin-left: auto;
    margin-right: auto;
    width: fit-content;
  }

  .form--disabled {
    cursor: not-allowed;
  }

  .form__submit {
    display: flex;
    justify-content: center;
  }

  .form__control {
    width: min-content;
    margin-left: auto;
    margin-right: auto;
  }

  .form__submit button {
    font-size: 15px;
    border-radius: 3px;
    background: hsla(160, 100%, 37%, 1);
    border: solid 1px hsla(160, 100%, 37%, 1);
    color: white;
    cursor: pointer;
    padding: 10px 50px;
    text-align: center;
    text-transform: uppercase;
  }

  .form__submit--disabled button {
    background: rgb(151, 169, 163);
    border: solid 1px rgb(151, 169, 163);
    color: white;
    cursor: not-allowed;
  }

  .form__label {
    font-family: 'Roboto', sans-serif;
    display: block;
    margin-bottom: 5px;
    font-size: 15px;
    min-width: 300px;
  }

  .form__input {
    border: solid 1px #e8e8e8;
    font-family: 'Roboto', sans-serif;
    padding: 10px 7px;
    margin-bottom: 8px;
    outline: none;
    font-size: 15px;
    border-radius: 3px;
    min-width: 300px;
  }

  .form__input--error {
    border: solid 1px red;
  }

  .form__error-message {
    display: block;
    color: red;
  }

  .form__input--disabled {
    cursor: not-allowed;
  }

  .button--reset {
    background: white !important;
    color: hsla(160, 100%, 37%, 1) !important;
    border: 1px solid hsla(160, 100%, 37%, 1) !important;
  }

  /* Chrome, Safari, Edge, Opera */
  .form__input--number input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  .form__input--number input[type=number] {
    -moz-appearance: textfield;
  }
}
</style>

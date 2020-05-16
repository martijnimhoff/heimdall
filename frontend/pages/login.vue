<template>
  <FormContainer>
    <template v-slot:title>
      <p>Please fill in your login credentials</p>
    </template>

    <form ref="loginform" @submit.prevent="login()">
      <b-field
          label="Email"
          :type="error.errors && error.errors.email ? 'is-danger' : ''"
          :message="error.errors ? error.errors.email : []"
      >
        <b-input
            type="email"
            name="email"
        />
      </b-field>

      <b-field
          label="Password"
          :type="error.errors && error.errors.password ? 'is-danger' : ''"
          :message="error.errors ? error.errors.password : []"
      >
        <b-input
            type="password"
            name="password"
        />
      </b-field>

      <button
          class="button is-success"
          @click.prevent="login"
      >
        Log in
      </button>

      <nuxt-link :to="{name: 'signup'}" class="button is-text">
        No account yet? Sign up.
      </nuxt-link>
    </form>
  </FormContainer>
</template>

<script>
  import FormContainer from "../components/FormContainer";

  export default {
    auth: 'guest',

    components: {
      FormContainer
    },

    data() {
      return {
        error: {}
      }
    },
    mounted() {
      // Before loading login page, obtain csrf cookie from the server.
      this.$axios.$get('/sanctum/csrf-cookie');
    },
    methods: {
      async login() {
        this.error = {};
        try {
          // Prepare form data
          const formData = new FormData(this.$refs.loginform);

          // Pass form data to `loginWith` function
          await this.$auth.loginWith('local', {data: formData});
        } catch (err) {
          this.error = err.response.data;
        }
      },
    },
  };
</script>

<template>
  <div class="columns m-t-md">
    <div class="container column is-6">
      <article class="message">
        <div class="message-header is-info">
          <p>Please fill in your login credentials</p>
        </div>
        <div class="message-body">
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
        </div>
      </article>
    </div>
  </div>


</template>

<script>
  export default {
    auth: 'guest',

    data() {
      return {
        error: {},
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

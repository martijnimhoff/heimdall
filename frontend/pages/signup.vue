<template>
  <FormContainer>
    <template v-slot:title>
      <p>Unlock the power of Heimdall today!</p>
    </template>

    <form ref="signupform" @submit.prevent="signup()" v-if="!isSignupSuccessful">

      <b-field
          label="Name"
          :type="error.errors && error.errors.name ? 'is-danger' : ''"
          :message="error.errors ? error.errors.name : []"
      >
        <b-input
            name="name"
        />
      </b-field>

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

      <b-field
          label="Confirm password"
          :type="error.errors && error.errors.password_confirmation ? 'is-danger' : ''"
          :message="error.errors ? error.errors.password_confirmation : []"
      >
        <b-input
            type="password"
            name="password_confirmation"
        />
      </b-field>

      <button
          class="button is-success"
          @click.prevent="signup"
      >
        Sign up
      </button>

      <nuxt-link :to="{name: 'login'}" class="button is-text">
        Already have account? Log in.
      </nuxt-link>
    </form>

    <div class="content" v-if="isSignupSuccessful">
      <p>
        Your account was created successfully. Before you can start using your account, you need
        to confirm your email.
      </p>

      <p>We've send a confirmation link to {{ email }}.</p>
    </div>
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
        error: {},
        isSignupSuccessful: false,
        email: null
      }
    },

    methods: {
      async signup() {
        this.error = {};
        try {
          // Prepare form data
          const formData = new FormData(this.$refs.signupform);
          const data = Object.fromEntries(formData);

          // Register the account on the backend
          await this.$axios.$post('/register', data);

          this.isSignupSuccessful = true;
          this.email = data.email;
        } catch (err) {
          // console.log(err)
          this.error = err.response.data;
        }
      }
    }
  }
</script>

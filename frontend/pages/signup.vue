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
        Your account was created successfully.
      </p>

      <p><nuxt-link :to="{name: 'login'}">Please click here to login.</nuxt-link></p>
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
        isSignupSuccessful: false
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
        } catch (err) {
          // console.log(err)
          this.error = err.response.data;
        }
      }
    }
  }
</script>

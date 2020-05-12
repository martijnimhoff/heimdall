<template>
  <div>
    <b-navbar class="header has-shadow is-dark">
      <template slot="brand">
        <b-navbar-item tag="router-link" :to="{ path: '/' }">
          <img
              src="~assets/logo.png"
              alt="Heimdall"
              height="28"
          >
        </b-navbar-item>
      </template>

      <template slot="end">
        <b-navbar-item tag="div">
          <div class="buttons">
            <nuxt-link class="button is-primary" :to="{name: 'signup'}" v-if="!$auth.loggedIn">
              <strong>Sign up</strong>
            </nuxt-link>
            <nuxt-link class="button is-light" :to="{name: 'login'}" v-if="!$auth.loggedIn">
              Log in
            </nuxt-link>
            <b-tooltip label="Are you sure you want to logout?"
                       position="is-left"
                       animated>
              <button class="button is-light"
                      @click="logout"
                      v-if="$auth.loggedIn"
              >
                <b-icon icon="power"></b-icon>
              </button>
            </b-tooltip>
          </div>
        </b-navbar-item>
      </template>
    </b-navbar>

    <section class="main-content columns">
      <aside class="column is-2 section" v-if="$auth.loggedIn">
        <p class="menu-label is-hidden-touch">
          General
        </p>
        <ul class="menu-list">
          <li
              v-for="(item, key) of items"
              :key="key"
          >
            <nuxt-link
                :to="item.to"
                exact-active-class="is-active"
            >
              <b-icon :icon="item.icon"/>
              {{ item.title }}
            </nuxt-link>
          </li>
        </ul>
      </aside>

      <div class="container column is-10">
        <nuxt/>
      </div>
    </section>
  </div>
</template>

<script>
  import {mdiAccountCircle} from '@mdi/js';

  export default {
    components: {
      mdiAccountCircle
    },
    data() {
      return {
        items: [
          {
            title: 'Watchers',
            icon: 'lighthouse-on',
            to: {name: 'index'}
          },
          {
            title: 'Account',
            icon: 'account-circle',
            to: {name: 'account'}
          },
        ],
        error: {}
      }
    },

    methods: {
      async logout() {
        try {
          await this.$auth.logout();
        } catch (err) {
          console.log(err);
          this.error = err;
        }
      }
    }
  }
</script>

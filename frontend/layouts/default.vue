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
            title: 'Dashboard',
            icon: 'desktop-mac-dashboard',
            to: {name: 'index'}
          },
          {
            title: 'Watchers',
            icon: 'lighthouse-on',
            to: {name: 'watcher'}
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
          this.error = err.response.data;
        }
      }
    }
  }
</script>

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
              <b-button class="is-light"
                        @click="logout"
                        v-if="$auth.loggedIn"
                        icon-left="power"
              />
            </b-tooltip>
          </div>
        </b-navbar-item>
      </template>
    </b-navbar>

    <section class="main-content columns">
      <aside class="column is-2 section" v-if="$auth.loggedIn">
        <b-menu>
          <b-menu-list label="Menu">
            <b-menu-item
                v-for="(menuItem, key) of items"
                :key="key"
                :icon="menuItem.icon"
                :label="menuItem.title"
                :to="menuItem.to"
                tag="nuxt-link"
                aria-role="menuitem"
                :active="menuItem.to.name === $route.name"
            />
          </b-menu-list>
        </b-menu>
      </aside>

      <div class="container column is-10 section">
        <nuxt/>
      </div>
    </section>
  </div>
</template>

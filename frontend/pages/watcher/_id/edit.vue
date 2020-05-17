<script>
  import gql from "graphql-tag";

  export default {
    validate({params}) {
      // Must be a number
      return /^\d+$/.test(params.id)
    },
    data() {
      return {
        watcher: null,
        id: this.$route.params.id,
        error: {}
      }
    },
    methods: {
      updateWatcher() {
        this.$apollo.mutate({
          mutation: gql`mutation ($id: Int!, $name: String!, $url: String!, $cssSelector: String!, $isScanning: Boolean!) {
            updateWatcher(id: $id, name: $name, url: $url, css_selector: $cssSelector, is_scanning: $isScanning) {
              id
              name
              url
              css_selector
              is_scanning
              created_at
              updated_at
              enabled_triggers_count
              scans_count
            }
          }`,
          variables: {
            id: this.watcher.id,
            name: this.watcher.name,
            url: this.watcher.url,
            cssSelector: this.watcher.css_selector,
            isScanning: this.watcher.is_scanning
          }
        })
          .then(data => data.data.updateWatcher)
          .then(updatedWatcher => {
            this.$buefy.toast.open({
              message: `${updatedWatcher.name} has been updated.`,
              type: 'is-success'
            })

            this.$router.push({
              name: 'watcher-id',
              params: {
                id: updatedWatcher.id
              }
            })
          })
          .catch(err => {
            console.log(err)
          })

      }
    },
    apollo: {
      watcher: {
        query: gql`query ($id: Int!){
          watcher(id: $id) {
            id
            name
            url
            css_selector
            is_scanning
          }
        }`,
        variables() {
          return {
            id: this.id
          }
        }
      }
    }
  }
</script>

<template>
  <div class="lead" v-if="watcher">
    <h1 class="title">Edit watcher: {{ watcher.name }}</h1>

    <div class="columns">
      <div class="column is-6">
        <form ref="updateWatcherForm" @submit.prevent="updateWatcher()">
          <b-field
              label="Name"
              :type="error.errors && error.errors.name ? 'is-danger' : ''"
              :message="error.errors ? error.errors.name : []"
          >
            <b-input
                type="text"
                name="name"
                v-model="watcher.name"
            />
          </b-field>
          <b-field
              label="Url"
              :type="error.errors && error.errors.url ? 'is-danger' : ''"
              :message="error.errors ? error.errors.url : []"
          >
            <b-input
                type="text"
                name="url"
                v-model="watcher.url"
            />
          </b-field>
          <b-field
              label="Css selector"
              :type="error.errors && error.errors.css_selector ? 'is-danger' : ''"
              :message="error.errors ? error.errors.css_selector : []"
          >
            <b-input
                type="text"
                name="css_selector"
                v-model="watcher.css_selector"
            />
          </b-field>
          <b-field
              :type="error.errors && error.errors.is_scanning ? 'is-danger' : ''"
              :message="error.errors ? error.errors.is_scanning : []"
          >
            <b-switch
                v-model="watcher.is_scanning"
                name="is_scanning"
            >
              {{ watcher.is_scanning ? 'Enabled' : 'Disabled' }}
            </b-switch>
          </b-field>

          <b-button
              outlined
              @click.prevent="$router.back()"
              label="Cancel"
          />
          <b-button
              class="is-success"
              @click.prevent="updateWatcher"
              label="Update"
          />
        </form>
      </div>
    </div>
  </div>
</template>

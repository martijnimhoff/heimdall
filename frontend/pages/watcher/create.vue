<script>
  import gql from "graphql-tag";

  export default {
    data() {
      return {
        error: {},
        isScanning: true
      }
    },
    methods: {
      createWatcher() {
        const formData = new FormData(this.$refs.createWatcherForm);
        const data = Object.fromEntries(formData);
        this.$apollo.mutate({
          mutation: gql`mutation ($name: String!, $url: String!, $cssSelector: String!, $isScanning: Boolean!) {
            createWatcher(name: $name, url: $url, css_selector: $cssSelector, is_scanning: $isScanning) {
              id
              name
            }
          }`,
          variables: {
            name: data.name,
            url: data.url,
            cssSelector: data.css_selector,
            isScanning: this.isScanning
          }
        })
          .then(data => data.data.createWatcher)
          .then(createdWatcher => {
            this.$buefy.toast.open({
              message: `${createdWatcher.name} has been created.`,
              type: 'is-success'
            })

            this.$router.push({
              name: 'watcher-id',
              params: {
                id: createdWatcher.id
              }
            })
          })
        .catch(err => {
          console.log(err)
        })
      }
    }
  }
</script>

<template>
  <div class="lead">
    <h1 class="title">Create watcher</h1>

    <div class="columns">
      <div class="column is-6">
        <form ref="createWatcherForm" @submit.prevent="createWatcher()">
          <b-field
              label="Name"
              :type="error.errors && error.errors.name ? 'is-danger' : ''"
              :message="error.errors ? error.errors.name : []"
          >
            <b-input
                type="text"
                name="name"
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
            />
          </b-field>
          <b-field
              :type="error.errors && error.errors.is_scanning ? 'is-danger' : ''"
              :message="error.errors ? error.errors.is_scanning : []"
          >
            <b-switch
                v-model="isScanning"
                name="is_scanning"
            >
              {{ isScanning ? 'Start enabled' : 'Start disabled' }}
            </b-switch>
          </b-field>

          <b-button
              outlined
              @click.prevent="$router.back()"
              label="Cancel"
          />
          <b-button
              class="button is-success"
              @click.prevent="createWatcher"
              label="Create"
          />
        </form>
      </div>
    </div>
  </div>
</template>

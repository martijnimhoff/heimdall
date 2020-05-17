<template>
  <div class="lead">
    <h1 class="title">Watchers</h1>
    <div class="buttons">
      <b-button class="is-primary" @click="goToCreateWatcher" icon-left="plus">
        Create
      </b-button>
      <b-button outlined class="is-primary" v-if="selected" @click="editSelectedWatcher" icon-left="pencil">
        Edit
      </b-button>
      <b-button outlined class="is-danger" @click="setScanning(false)" v-if="selected && selected.is_scanning" icon-left="lighthouse">
        Deactivate
      </b-button>
      <b-button outlined class="is-success" @click="setScanning(true)" v-if="selected && !selected.is_scanning" icon-left="lighthouse-on">
        Activate
      </b-button>
      <b-button outlined class="is-info" :loading="$apollo.queries.watchers.loading" @click="reload" icon-left="sync">
        Reload
      </b-button>
      <b-button outlined class="is-dark" @click="selected = null" v-if="selected" icon-left="close">
        Clear
      </b-button>
    </div>
    <b-table
        :data="watchers"
        :columns="columns"
        :selected.sync="selected"
        focusable
    />
  </div>
</template>

<script>
  import gql from 'graphql-tag'

  export default {
    data() {
      return {
        columns: [
          {
            field: 'id',
            label: 'ID',
            width: 45,
            numeric: true
          },
          {
            field: 'name',
            label: 'Name'
          },
          {
            field: 'is_scanning',
            label: 'Is scanning'
          },
          {
            field: 'enabled_triggers_count',
            label: 'Active triggers'
          },
          {
            field: 'scans_count',
            label: 'Scans'
          }
        ],
        watchers: [],
        selected: null
      }
    },
    methods: {
      reload() {
        this.watchers = [];
        this.checkedRows = [];
        this.$apollo.queries.watchers.refetch();
      },
      setScanning(isScanning) {
        this.$apollo.mutate({
          mutation: gql`mutation ($id: Int!, $isScanning: Boolean!) {
            updateWatcher(id: $id, is_scanning: $isScanning) {
              id
              name
              is_scanning
              enabled_triggers_count
              scans_count
            }
          }`,
          variables: {
            id: this.selected.id,
            isScanning
          }
        })
          .then(data => data.data.updateWatcher)
          .then(updatedWatcher => {
            this.$buefy.toast.open({
              message: `${updatedWatcher.name} has been updated.`,
              type: 'is-success'
            })
          })

        // unselect, because the table automatically unselects because we update the watcher object in the apollo cache.
        this.selected = null;
      },
      goToCreateWatcher() {

      },
      editSelectedWatcher() {

      }
    },
    apollo: {
      watchers: {
        query: gql`{
          watchers {
            id
            name
            is_scanning
            enabled_triggers_count
            scans_count
          }
        }`
      }
    }
  }
</script>

<style lang="scss">

</style>

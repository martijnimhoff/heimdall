<template>
  <div class="lead">
    <h1 class="title">Watchers</h1>
    <div class="buttons is-pulled-right">
      <b-button outlined class="is-info" :loading="$apollo.queries.watchers.loading" @click="reload" icon-left="sync">
        Reload
      </b-button>
    </div>
    <div class="buttons">
      <b-button class="is-primary" @click="createWatcher" icon-left="plus">
        Create
      </b-button>
    </div>
    <b-table
        :data="watchers"
        :striped="true"
    >
      <template slot-scope="props">
        <b-table-column field="id" label="ID" width="40" numeric>
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="name" label="Name">
          {{ props.row.name }}
        </b-table-column>
        <b-table-column field="is_scanning" label="Is scanning">
          {{ props.row.is_scanning }}
        </b-table-column>
        <b-table-column field="enabled_triggers_count" label="Active triggers">
          {{ props.row.enabled_triggers_count }}
        </b-table-column>
        <b-table-column field="scans_count" label="Scans">
          {{ props.row.scans_count }}
        </b-table-column>

        <b-table-column custom-key="actions">
          <b-button
              class="is-primary is-small"
              @click="openWatcher(props.row)"
              icon-left="eye"
              label="view"
          />
          <b-button
              outlined
              class="is-primary is-small"
              @click="editWatcher(props.row)"
              icon-left="pencil"
              label="edit"
          />
          <b-button
              outlined
              class="is-danger is-small"
              @click="setScanning(props.row, false)"
              icon-left="lighthouse"
              label="deactivate"
              v-if="props.row.is_scanning"
          />
          <b-button
              outlined
              class="is-success is-small"
              @click="setScanning(props.row, true)"
              icon-left="lighthouse-on"
              label="activate"
              v-if="!props.row.is_scanning"
          />
        </b-table-column>
      </template>
    </b-table>
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
      }
    },
    methods: {
      reload() {
        this.watchers = [];
        this.$apollo.queries.watchers.refetch();
      },
      setScanning(watcher, isScanning) {
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
            id: watcher.id,
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
      },
      createWatcher() {
        this.$router.push({
          name: 'watcher-create'
        })
      },
      openWatcher(watcher) {
        this.$router.push({
          name: 'watcher-id',
          params: {
            id: watcher.id
          }
        })
      },
      editWatcher(watcher) {
        this.$router.push({
          name: 'watcher-id-edit',
          params: {
            id: watcher.id
          }
        })
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

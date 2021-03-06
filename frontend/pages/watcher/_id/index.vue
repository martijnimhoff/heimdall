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
        triggers: [],
        scans: [],
        hits: [],
        activeTab: 0
      }
    },
    methods: {
      editWatcher() {
        this.$router.push({
          name: 'watcher-id-edit',
          params: {
            id: this.id
          }
        })
      },
      createTrigger() {
        this.$router.push({
          name: 'watcher-id-createTrigger',
          params: {
            id: this.id
          }
        })
      },
      editTrigger(triggerId) {
        this.$router.push({
          name: 'trigger-id-edit',
          params: {
            id: triggerId
          }
        })
      },
      toggleTrigger(triggerId, setEnabled) {
        this.$apollo.mutate({
          mutation: gql`mutation ($id: Int!, $isEnabled: Boolean!) {
            updateTrigger(id: $id, is_enabled: $isEnabled) {
              id
              watcher_id
              trigger_type_id
              value_to_match
              is_enabled
              created_at
              updated_at
            }
          }`,
          variables: {
            id: triggerId,
            isEnabled: setEnabled
          }
        })
          .then(() => {
            const newState = setEnabled ? 'enabled' : 'disabled';

            this.$buefy.toast.open({
              message: `A trigger has been ${newState}.`,
              type: 'is-success'
            })
          })
      },
      deleteTrigger(triggerId) {
        this.$apollo.mutate({
          mutation: gql`mutation ($id: Int!) {
            deleteTrigger(id: $id) {
              id
            }
          }`,
          variables: {
            id: triggerId
          },
          update: () => {
            // TODO delete trigger from local cache
          }
        })
          .then(() => {
            this.$buefy.toast.open({
              message: `Trigger has been deleted.`,
              type: 'is-success'
            })
          })
      }
    },
    computed: {
      watcherData() {
        let data = [];
        Object.entries(this.watcher).forEach((entry) => {
          data.push({
            name: entry[0],
            value: entry[1],
          })
        })
        return data;
      }
    },
    apollo: {
      watcher: {
        query: gql`query ($id: Int!) {
          watcher(id: $id) {
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
        variables() {
          return {
            id: this.id
          }
        }
      },
      triggers: {
        query: gql`query ($watcherId: Int!) {
          triggers(watcher_id: $watcherId) {
            id
            watcher_id
            trigger_type_id
            value_to_match
            is_enabled
            created_at
            updated_at
          }
        }`,
        variables() {
          return {
            watcherId: this.id
          }
        }
      },
      scans: {
        query: gql`query ($watcherId: Int!) {
          scans(watcher_id: $watcherId) {
            id
            watcher_id
            value
            created_at
            updated_at
          }
        }`,
        variables() {
          return {
            watcherId: this.id
          }
        }
      },
      hits: {
        query: gql`query ($watcherId: Int!) {
          hits(watcher_id: $watcherId) {
            id
            scan_id
            trigger_id
            trigger_type_id
            trigger_value
            created_at
            updated_at
          }
        }`,
        variables() {
          return {
            watcherId: this.id
          }
        }
      }
    }
  }
</script>

<template>
  <div class="lead" v-if="watcher">
    <h1 class="title">Watcher: {{ watcher.name }}</h1>

    <div class="buttons">
      <b-button
          outlined
          class="is-primary"
          @click="editWatcher"
          icon-left="pencil"
          label="edit"
      />
      <b-button
          outlined
          class="is-primary"
          @click="createTrigger"
          icon-left="plus"
          label="add trigger"
      />
    </div>

    <b-tabs v-model="activeTab">
      <b-tab-item label="Info">
        <b-table :data="watcherData">
          <template slot-scope="props">
            <b-table-column field="name" label="Name">
              {{ props.row.name }}
            </b-table-column>
            <b-table-column field="value" label="Value" class="is-italic">
              {{ props.row.value }}
            </b-table-column>
          </template>
        </b-table>
      </b-tab-item>
      <b-tab-item label="Triggers">
        <b-table :data="triggers">
          <template slot-scope="props">
            <b-table-column field="id" label="ID">
              {{ props.row.id }}
            </b-table-column>
            <b-table-column field="trigger_type_id" label="Trigger type">
              {{ props.row.trigger_type_id }}
            </b-table-column>
            <b-table-column field="value_to_match" label="Value to match">
              {{ props.row.value_to_match }}
            </b-table-column>
            <b-table-column field="is_enabled" label="Is enabled">
              {{ props.row.is_enabled }}
            </b-table-column>
            <b-table-column custom-key="actions">
              <b-button
                  outlined
                  class="is-primary is-small"
                  @click="editTrigger(props.row.id)"
                  icon-left="pencil"
                  label="edit"
              />
              <b-button
                  outlined
                  class="is-danger is-small"
                  @click="toggleTrigger(props.row.id, false)"
                  icon-left="eye-off"
                  label="disable"
                  v-if="props.row.is_enabled"
              />
              <b-button
                  outlined
                  class="is-success is-small"
                  @click="toggleTrigger(props.row.id, true)"
                  icon-left="eye"
                  label="enable"
                  v-if="!props.row.is_enabled"
              />
              <b-button
                  outlined
                  class="is-danger is-small"
                  @click="deleteTrigger(props.row.id)"
                  icon-left="delete"
                  label="delete"
              />
            </b-table-column>
          </template>
        </b-table>
      </b-tab-item>
      <b-tab-item label="Scans">
        <b-table :data="scans">
          <template slot-scope="props">
            <b-table-column field="id" label="ID">
              {{ props.row.id }}
            </b-table-column>
            <b-table-column field="value" label="Recorded value">
              {{ props.row.value }}
            </b-table-column>
            <b-table-column field="created_at" label="Recorded at">
              {{ props.row.created_at }}
            </b-table-column>
          </template>
        </b-table>
      </b-tab-item>
      <b-tab-item label="Hits">
        <b-table :data="hits">
          <template slot-scope="props">
            <b-table-column field="id" label="ID">
              {{ props.row.id }}
            </b-table-column>
            <b-table-column field="trigger_id" label="Trigger">
              {{ props.row.trigger_id }}
            </b-table-column>
            <b-table-column field="trigger_value" label="Historical trigger value">
              {{ props.row.trigger_value }}
            </b-table-column>
            <b-table-column field="created_at" label="Happened at">
              {{ props.row.created_at }}
            </b-table-column>
          </template>
        </b-table>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<style lang="scss">
  .b-table {
    word-break: break-word;
  }

  .b-tabs .tab-content {
    padding: 0;
  }
</style>

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
        hits: []
      }
    },
    methods: {
      editWatcher(watcher) {
        this.$router.push({
          name: 'watcher-id-edit',
          params: {
            id: watcher.id
          }
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
        query: gql`query ($id: Int!){
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
          @click="editWatcher(props.row)"
          icon-left="pencil"
          label="edit"
      />
    </div>

    <div class="columns">
      <div class="column is-9">
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
      </div>
    </div>

    <h2 class="subtitle">Triggers</h2>
  </div>
</template>

<style lang="scss" scoped>
  .b-table {
    word-break: break-word;
  }
</style>

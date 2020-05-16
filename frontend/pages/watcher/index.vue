<template>
  <div class="lead">
    <h1 class="title">Watchers</h1>
    <div class="buttons">
      <b-button outlined class="is-danger" @click="setScanning(false)">
        <b-icon icon="lighthouse"></b-icon>
        <span>Deactivate scanning</span>
      </b-button>
      <b-button outlined class="is-success" @click="setScanning(true)">
        <b-icon icon="lighthouse-on"></b-icon>
        <span>Activate scanning</span>
      </b-button>
      <b-button outlined class="is-info" :loading="$apollo.queries.watchers.loading" @click="reload">
        <b-icon icon="sync"></b-icon>
        <span>Reload</span>
      </b-button>
    </div>
    <b-table
        :data="watchers"
        :columns="columns"
        :checked-rows.sync="checkedRows"
        checkable
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
        checkedRows: []
      }
    },
    methods: {
      reload() {
        this.watchers = [];
        this.checkedRows = [];
        this.$apollo.queries.watchers.refetch();
      },
      setScanning(isScanning) {

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

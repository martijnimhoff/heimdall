<script>
  import gql from "graphql-tag";

  export default {
    validate({params}) {
      // Must be a number
      return /^\d+$/.test(params.id)
    },
    data() {
      return {
        triggerTypes: [],
        trigger: null,
        id: this.$route.params.id,
        error: {}
      }
    },
    methods: {
      updateTrigger() {
        this.$apollo.mutate({
          mutation: gql`mutation ($id: Int!, $watcherId: Int!, $triggerTypeId: Int!, $valueToMatch: String!, $isEnabled: Boolean!) {
            updateTrigger(id: $id, watcher_id: $watcherId, trigger_type_id: $triggerTypeId, value_to_match: $valueToMatch, is_enabled: $isEnabled) {
              id
              watcher_id
              trigger_type_id
              value_to_match
              is_enabled
            }
          }`,
          variables: {
            id: this.trigger.id,
            watcherId: this.trigger.watcher_id,
            triggerTypeId: this.trigger.trigger_type_id,
            valueToMatch: this.trigger.value_to_match,
            isEnabled: this.trigger.is_enabled,
          }
        })
          .then(data => data.data.createTrigger)
          .then(() => {
            this.$buefy.toast.open({
              message: `A trigger has been updated.`,
              type: 'is-success'
            })

            this.$router.push({
              name: 'watcher-id',
              params: {
                id: this.trigger.watcher_id
              }
            })
          })
          .catch(err => {
            console.log(err)
          })
      }
    },
    apollo: {
      trigger: {
        query: gql`query ($id: Int!){
          trigger(id: $id) {
            id
            watcher_id
            trigger_type_id
            value_to_match
            is_enabled
          }
        }`,
        variables() {
          return {
            id: this.id
          }
        }
      },
      triggerTypes: {
        query: gql`query {
          triggerTypes {
            id
            name
          }
        }`,
      }
    }
  }
</script>

<template>
  <div class="lead">
    <h1 class="title">Update trigger</h1>

    <div class="columns" v-if="trigger">
      <div class="column is-6">
        <form ref="updateTriggerForm" @submit.prevent="updateTrigger()">
          <b-field
              label="Trigger type"
              :type="error.errors && error.errors.trigger_type_id ? 'is-danger' : ''"
              :message="error.errors ? error.errors.trigger_type_id : []"
          >
            <b-select
                placeholder="Select a type"
                name="trigger_type_id"
                v-model="trigger.trigger_type_id"
            >
              <option
                  v-for="triggerType in triggerTypes"
                  :key="triggerType.id"
                  :value="triggerType.id"
              >
                {{ triggerType.name }}
              </option>
            </b-select>
          </b-field>

          <b-field
              label="Value to match"
              :type="error.errors && error.errors.value_to_match ? 'is-danger' : ''"
              :message="error.errors ? error.errors.value_to_match : []"
          >
            <b-input
                type="text"
                name="value_to_match"
                v-model="trigger.value_to_match"
            />
          </b-field>

          <b-field
              :type="error.errors && error.errors.is_scanning ? 'is-danger' : ''"
              :message="error.errors ? error.errors.is_scanning : []"
          >
            <b-switch
                v-model="trigger.is_enabled"
                name="is_enabled"
            >
              {{ trigger.is_enabled ? 'Enabled' : 'Disabled' }}
            </b-switch>
          </b-field>

          <b-button
              outlined
              @click.prevent="$router.back()"
              label="Cancel"
          />
          <b-button
              class="button is-success"
              @click.prevent="updateTrigger"
              label="Update"
          />
        </form>
      </div>
    </div>
  </div>
</template>

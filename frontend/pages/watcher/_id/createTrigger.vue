<script>
  import gql from "graphql-tag";

  export default {
    validate({params}) {
      // Must be a number
      return /^\d+$/.test(params.id)
    },
    data() {
      return {
        error: {},
        watcherId: this.$route.params.id,
        triggerTypes: [],
        triggerTypeId: null,
        valueToMatch: '',
        isEnabled: true,
      }
    },
    methods: {
      createTrigger() {
        this.$apollo.mutate({
          mutation: gql`mutation ($watcherId: Int!, $triggerTypeId: Int!, $valueToMatch: String!, $isEnabled: Boolean!) {
            createTrigger(watcher_id: $watcherId, trigger_type_id: $triggerTypeId, value_to_match: $valueToMatch, is_enabled: $isEnabled) {
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
            watcherId: this.watcherId,
            triggerTypeId: this.triggerTypeId,
            valueToMatch: this.valueToMatch,
            isEnabled: this.isEnabled,
          }
        })
          .then(data => data.data.createTrigger)
          .then(() => {
            this.$buefy.toast.open({
              message: `A trigger has been created.`,
              type: 'is-success'
            })

            this.$router.push({
              name: 'watcher-id',
              params: {
                id: this.watcherId
              }
            })
          })
          .catch(err => {
            console.log(err)
          })
      }
    },
    apollo: {
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
    <h1 class="title">Create trigger</h1>

    <div class="columns">
      <div class="column is-6">
        <form ref="createTriggerForm" @submit.prevent="createTrigger()">
          <b-field
              label="Trigger type"
              :type="error.errors && error.errors.trigger_type_id ? 'is-danger' : ''"
              :message="error.errors ? error.errors.trigger_type_id : []"
          >
            <b-select
                placeholder="Select a type"
                name="trigger_type_id"
                v-model="triggerTypeId"
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
                v-model="valueToMatch"
            />
          </b-field>

          <b-field
              :type="error.errors && error.errors.is_scanning ? 'is-danger' : ''"
              :message="error.errors ? error.errors.is_scanning : []"
          >
            <b-switch
                v-model="isEnabled"
                name="is_enabled"
            >
              {{ isEnabled ? 'Start enabled' : 'Start disabled' }}
            </b-switch>
          </b-field>

          <b-button
              class="button is-success"
              @click.prevent="createTrigger"
              label="Create"
          />
        </form>
      </div>
    </div>
  </div>
</template>

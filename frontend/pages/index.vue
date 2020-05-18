<script>
  import Card from '~/components/Card'

  export default {
    name: 'HomePage',

    components: {
      Card
    }
  }
</script>

<template>
  <div class="columns">
    <card
        title="Dashboard"
        icon="desktop-mac-dashboard"
        tooltip="I mean, it has a simple and intuitive design"
    >
      Well.. this dashboard is quite empty.
    </card>
  </div>
</template>

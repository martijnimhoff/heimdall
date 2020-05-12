<template>
  <section class="section">
    <div class="columns is-mobile">
      <card
          title="Heimdall"
          icon="user"
      >
        Watches over the internet
      </card>
    </div>
  </section>
</template>

<script>
  import Card from '~/components/Card'

  export default {
    name: 'HomePage',

    components: {
      Card
    }
  }
</script>

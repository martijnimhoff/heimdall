<template>
  <div class="columns m-t-md">
    <div class="container column is-6">
      <article class="message">
        <div class="message-header is-info">
          <slot name="title"/>
        </div>
        <div class="message-body">
          <slot/>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'FormContainer'
  }
</script>

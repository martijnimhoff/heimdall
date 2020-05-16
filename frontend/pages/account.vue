<template>
  <article class="message">
    <div class="message-header">
      Your account information
    </div>
    <div class="message-body">
      <p>Name: {{ $auth.user.name }}</p>
      <p>Email: {{ $auth.user.email }}</p>
    </div>
  </article>
</template>

<script>
  export default {
    middleware: 'auth'
  }
</script>

<template>
  <card title="Home">
    You are logged in
  </card>
</template>

<script>
export default {
  middleware: 'auth',

  head () {
    return { title: 'home' }
  }
}
</script>

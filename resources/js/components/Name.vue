<template>
   <strong>
      {{ user.name }}
   </strong>
</template>

<script>
export default {
  computed: {
    user () {
      return this.$store.state.auth;
    }
}
}
</script>

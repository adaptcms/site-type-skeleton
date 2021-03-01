<template>
  <div>
    <p>
      Enjoy this site type {{ packageName }} created by {{ vendor }}.
    </p>
  </div>
</template>

<script>
export default {
  props: [
    'vendor',
    'packageName'
  ]
}
</script>

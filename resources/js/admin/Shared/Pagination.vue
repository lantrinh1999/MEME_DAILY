<template>
  <div class="mt-2 pt-1">
    <ul
      class="pagination-separated justify-content-center twbs-separated pagination pagination-default"
    >
      <template v-for="(link, key) in links">
        <li
          v-if="link.url === null"
          :key="key"
          class="page-item"
          :class="{ 'disabled': link.url === null, 'prev' : link.label === 'Previous' }"
        >
          <inertia-link preserve-scroll :href="link.url || ''" class="page-link">{{ link.label }}</inertia-link>
        </li>
        <li
          v-else
          :key="key"
          class="page-item"
          :class="{ 'active': link.active, 'next': link.label === 'Next' }"
        >
          <inertia-link
            :class="{ 'active': link.active}"
            preserve-scroll
            :href="link.url || ''"
            class="page-link"
          >{{ link.label }}</inertia-link>
        </li>
      </template>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
  mounted() {},
};
</script>
<style>
@media only screen and (max-width: 767px) {
  .page-item {
    display: none !important;
  }
  .page-item:first-child,
  .page-item:last-child {
    display: block !important;
  }

  a.active {
    pointer-events: none !important;
  }
}
</style>

<template>
  <div id="app" class="mt-5">
    <v-app>
    <loading ref="loading" />
    <transition name="page" mode="out-in">
      <v-content class="pt-10">
        <component :is="layout" v-if="layout" />
      </v-content>
    </transition>
    </v-app>
  </div>
</template>

<script>
import Loading from './Loading'
import Vuetify from 'Vuetify'
// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',
  // vuetify: new Vuetify(),
  vuetify: new Vuetify({
    theme: { dark: true }
  }),
  components: {
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default'
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>

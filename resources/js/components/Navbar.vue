<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-if="user"
      v-model="drawer"
      app
      clipped
    >
      <v-list dense>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-bullseye-arrow</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <!-- <router-link :to="{ name: 'messages' }"> -->
            <v-list-item-title>
              Competencia (Comming soon)<!-- {{ $t('messages') }} -->
            </v-list-item-title>
            <!-- </router-link> -->
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-forum</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <router-link :to="{ name: 'messages' }">
              <v-list-item-title>
                {{ $t('messages') }}
              </v-list-item-title>
            </router-link>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-transit-connection-variant</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <!-- <router-link :to="{ name: 'settings.profile' }"> -->
            <v-list-item-title>
              Proveedores (Comming soon)<!-- {{ $t('settings') }} -->
            </v-list-item-title>
            <!-- </router-link> -->
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-package-variant-closed</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <!-- <router-link :to="{ name: 'settings.profile' }"> -->
            <v-list-item-title>
              Inventario (Comming soon)<!-- {{ $t('settings') }} -->
            </v-list-item-title>
            <!-- </router-link> -->
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-settings</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <router-link :to="{ name: 'settings.profile' }">
              <v-list-item-title>
                {{ $t('settings') }}
              </v-list-item-title>
            </router-link>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      clipped-left
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>ECOM-MARKETICS</v-toolbar-title>
      <v-spacer />

      <DropDownMenu />
    </v-app-bar>

    <v-footer app>
      <span>MARKETICS &copy; 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },
  props: {
    source: String
  },

  data: () => ({
    appName: window.config.appName,
    drawer: null
  }),
  created () {
    this.$vuetify.theme.dark = true
  },
  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style >
.v-list-item__title {
  color: white !important;
  text-decoration: none !important;
}
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
.v-application--wrap{
      min-height: 0 !important;
}

</style>

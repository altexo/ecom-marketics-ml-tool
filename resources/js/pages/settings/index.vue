<template>
  <v-row>
    <!-- <div class="col-md-3">
      <card :title="$t('settings')" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </card>
    </div> -->
    <v-col col="2" md="4" sm="5">
      <v-card
        class="mx-auto"
        width="400"
      >
        <v-toolbar
          color="#7070c5"
          dark
          dense
        >
          <v-toolbar-title>{{ $t('settings') }}</v-toolbar-title>
        </v-toolbar>
        <v-list v-for="tab in tabs" :key="tab.route">
          <router-link :to="{ name: tab.route }" active-class="active">
            <v-list-item>
              <v-list-item-icon>
                <v-icon>{{ tab.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-title>  {{ tab.name }}</v-list-item-title>
            </v-list-item>
          </router-link>
        </v-list>
        <v-list>
          <a href="#" @click.prevent="logout">
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-logout</v-icon>
              </v-list-item-icon>
              <v-list-item-title>  {{ $t('logout') }}</v-list-item-title>
            </v-list-item>
          </a>
        </v-list>
      </v-card>
    </v-col>

    <v-col col="10" md="8" sm="7">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'mdi-profile',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'mdi-lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  },
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

<style>
.settings-card .card-body {
  padding: 0;
}
.v-list{
  padding: 0px 0;
}
/* .card-header{
color:white
} */
</style>

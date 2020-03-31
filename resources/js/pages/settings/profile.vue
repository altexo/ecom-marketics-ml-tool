<template>
  <v-card
    class="mx-auto"
  >
      <v-toolbar
          color="#7070c5"
          dark
          dense
        >
          <v-toolbar-title>{{ $t('your_info') }}</v-toolbar-title>
        </v-toolbar>
    <v-card-text>
      <alert-success :form="form" :message="$t('info_updated')" />
    </v-card-text>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <v-col col="12">
        <has-error :form="form" field="name" />
        <v-text-field
          v-model="form.name"
          :label="$t('name')"
          outlined
          
          :class="{ 'is-invalid': form.errors.has('name') }"
          type="name"
        />

        <has-error :form="form" field="email" />
        <v-text-field
          v-model="form.email"
          :label="$t('email')"
          outlined
          
          :class="{ 'is-invalid': form.errors.has('email') }"
          type="email"
        />
      </v-col>

      <v-card-actions>
        <!-- <v-button color="#7070c5" :loading="form.busy">
            {{ $t('login') }}
          </v-button> -->
        <v-btn
          :loading="form.busy"
          color="#7070c5"
          type="submit"
        >
          {{ $t('update') }}
        </v-btn>
      </v-card-actions>
    </form>
    <v-spacer />
    </v-card-actions>
  </v-card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>

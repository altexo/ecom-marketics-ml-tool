<template>
  <!-- <card :title="$t('your_password')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('password_updated')" />

      <!-- Password --
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('password_updated') }}</label>
        <div class="col-md-7">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
          <has-error :form="form" field="password" />
        </div>
      </div>

      <!-- Password Confirmation --
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
        <div class="col-md-7">
          <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
          <has-error :form="form" field="password_confirmation" />
        </div>
      </div>

      <!-- Submit Button --
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('update') }}
          </v-button>
        </div>
      </div>
    </form>
  </card> -->
    <v-card
    class="mx-auto"
  >
      <v-toolbar
          color="#7070c5"
          dark
        >
          <v-toolbar-title>{{ $t('your_password') }}</v-toolbar-title>
        </v-toolbar>
    <v-card-text>
      <alert-success :form="form" :message="$t('password_updated')" />
    </v-card-text>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <v-col col="12">
        <has-error :form="form" field="password" />
        <v-text-field
          v-model="form.password"
          :label="$t('password')"
          outlined
          
          :class="{ 'is-invalid': form.errors.has('password') }"
          type="password"
        />

        <has-error :form="form" field="password_confirmation" />
        <v-text-field
          v-model="form.password_confirmation"
          :label="$t('confirm_password')"
          outlined
          
          :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
          type="password"
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

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>

<template>
  <!-- <div class="row">
    <div class="col-lg-8 m-auto"> -->
  <!-- <card :title="$t('login')">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email --
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Password --
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Remember Me --
          <div class="form-group row">
            <div class="col-md-3" />
            <div class="col-md-7 d-flex">
              <checkbox v-model="remember" name="remember">
                {{ $t('remember_me') }}
              </checkbox>

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button --
              <v-button :loading="form.busy">
                {{ $t('login') }}
              </v-button>

              <!-- GitHub Login Button --
              <login-with-github />
            </div>
          </div>
        </form>
      </card> -->
  <!-- </div>
  </div> -->
  <v-row class="mt-3">
    <v-card
      class="mx-auto"
    >
      <v-list-item>
        <v-list-item-avatar><img :src="'../../../../images/Ecom-marketicks.png'"></v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="headline">
            {{ $t('login') }}
          </v-list-item-title>
          <v-list-item-subtitle>Haz crecer tu negocio de Ecommerce</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-img
        :src="'../../../../images/space.jpg'"
        height="194"
      />

      <v-card-text>
        Visit ten places on our planet that are undergoing the biggest changes today.
      </v-card-text>
      <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <v-col col="12">
          <has-error :form="form" field="email" />
          <v-text-field
            v-model="form.email"
            :label="$t('email')"
            outlined
            shaped
            :class="{ 'is-invalid': form.errors.has('email') }"
            type="email"
          />

          <has-error :form="form" field="password" />
          <v-text-field
            v-model="form.password"
            :label="$t('password')"
            outlined
            shaped
            :class="{ 'is-invalid': form.errors.has('password') }"
            type="password"
          />

          <v-checkbox v-model="remember"
                      class="mt-0"
                      :label="$t('remember_me')"
                      name="remember"
          />
          <!-- <checkbox v-model="remember" name="remember">
            {{ $t('remember_me') }}
          </checkbox> -->
          <router-link :to="{ name: 'password.request' }" class="link small ml-auto my-auto">
            {{ $t('forgot_password') }}
          </router-link>
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
            {{ $t('login') }}
          </v-btn>

          <v-btn
            to="/register"
            color="#7070c5"
          >
            {{ $t('register') }}
          </v-btn>
        </v-card-actions>
      </form>
      <v-spacer />
        <!-- <router-link :to="{ name: 'password.request' }" class="link small ml-auto my-auto">
          {{ $t('forgot_password') }}
        </router-link> -->
        <!-- <v-btn icon>
          <v-icon>mdi-heart</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon>mdi-share-variant</v-icon>
        </v-btn> -->
      </v-card-actions>
    </v-card>
  </v-row>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      console.log(this.from)
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
<style>
.col{
  padding-right: 12px;
    padding-left: 12px;
}
.link{
  color: white;
  text-decoration: none;
}
.help-block.invalid-feedback{
  color: red;
}
</style>

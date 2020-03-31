<template>
  <v-row class="row">
    <v-col col="5">
      <v-card
        class="mx-auto"
        max-width="400"
        tile
        :loading="loadingMsgs"
      >
        <v-list
          :disabled="disabled"
          :dense="dense"
          :two-line="twoLine"
          :three-line="threeLine"
          :shaped="shaped"
          :flat="flat"
          :subheader="subheader"
          :sub-group="subGroup"
          :nav="nav"
          :avatar="avatar"
          :rounded="rounded"
        >
          <v-subheader class="mt-2">
            {{ $t('messages') }}
            <v-spacer />
            <v-flex xs5>
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="search"
                    single-line
                    :label="$t('search')"
                    append-icon="mdi-magnify"
                    color="grey lighten-5"
                    v-on="on"
                    @keyup="updateData();"
                  />
                </template>
                <span>{{ $t('tooltip.search') }}</span>
              </v-tooltip>
            </v-flex>
            <!-- <v-btn icon>
              <v-icon>mdi-magnify</v-icon>
            </v-btn> -->

            <v-switch v-model="switch1" color="success" :label="switch1Label" />
          </v-subheader>
          <v-list-item-group v-model="item" color="primary" class="scroll-y overflow-y-auto" style="max-height: 75vh !important">
            <!-- If empty messages -->
            <v-list-item v-show="messages.length == 0">
              <v-list-item-content>
                <v-list-item-title>
                  {{ $t('empty_messages') }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <!-- Else empty messages -->
            <v-list-item
              v-for="(item, i) in messages"
              v-show="messages.length > 0"
              :key="i"
              :inactive="inactive"
              @click="changeOrderPropValue(item)"
            >
              <v-list-item-avatar v-if="avatar">
                <v-img :src="item.image" />
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title v-text="item.title" />
                <v-list-item-subtitle v-if="twoLine || threeLine" v-text="item.messages.conversation[0].text" />
              </v-list-item-content>
              <v-list-item-action>
                <v-list-item-action-text v-text="item.buyer_nickname" />
                <v-list-item-action-text v-text="'18hr'" />
              </v-list-item-action>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-card>
    </v-col>
    <v-col col="7">
      <transition name="fade" mode="out-in">
        <ChatComponent :order="order" />
      </transition>
    </v-col>
  </v-row>
</template>

<script>
// import Vuetify from 'Vuetify'
import axios from 'axios'
// import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',
  data () {
    return {
      messages: [],
      order: null,
      item: 5,
      disabled: false,
      dense: false,
      twoLine: true,
      threeLine: false,
      shaped: true,
      flat: false,
      subheader: true,
      inactive: false,
      subGroup: false,
      nav: false,
      avatar: true,
      rounded: true,
      switch1: false,
      switch1Label: this.$t('read'),
      search: '',
      loadingMsgs: false

    }
  },
  watch: {
    switch1 () {
      if (this.switch1 === true) {
        this.loadingMsgs = true
        this.switch1Label = this.$t('unread')
        this.getUnreadMessages()
      } else {
        this.loadingMsgs = true
        this.switch1Label = this.$t('read')
        this.getAllMessages()
      }
    }
  },
  mounted () {
    // this.switch1Label = this.$t('')
    this.getAllMessages()
    // axios.post('/api/messages/send', { 'msg': 'Hi joe doe!' }).then(response => {
    //   console.log('Send Msg response: ', response)
    // })
    // console.log('Computed', this.$store.state.auth.user.ml_accounts[0].ml_user_id)
    console.log('Computed', this.$store.state)
  },

  methods: {
    changeOrderPropValue (order) {
      // console.log('From parent: ', order)
      this.order = order
    },
    getUnreadMessages () {
      this.loadingMsgs = true
      axios.get('api/messages/unread/' + this.$store.state.auth.current_ml_account.ml_user_id)
        .then(response => {
          this.messages = response.data
          this.loadingMsgs = false
          console.log('Unread: ', response.data)
        })
    },
    getAllMessages () {
      this.loadingMsgs = true
      axios.get('/api/messages/' + this.$store.state.auth.current_ml_account.ml_user_id)
        .then(response => {
          this.messages = response.data
          this.loadingMsgs = false
          console.log(this.messages)
        })
    },
    updateData () {
      this.loadingMsgs = true
      axios.get('/api/messages/search/' + this.$store.state.auth.current_ml_account.ml_user_id + '/' + this.search)
        .then(response => {
          this.messages = response.data
          this.loadingMsgs = false
          console.log(this.messages)
        })
      // console.log(this.search)
    }
  }
}

</script>

<style>
.messages-card{
  background-color: #363636;
  color: white;
  border: 1px solid #363636;
}
.card-header{
  background-color: #363636;
  border-bottom: 1px solid #363636;
}
.messages-container{
  padding-left: 0px
}
.card-body {
  padding: 0;
}
.mx-auto.v-card.v-card--outlined.v-sheet.theme--dark{
      max-width: 100% !important;
}
.headline{
  text-align: left !important;
}
.v-content{
  padding-top: 0px !important;
}
.v-subheader{
  background-color: #7070c5;
}
/* .nav-item{
  pad
} */
</style>

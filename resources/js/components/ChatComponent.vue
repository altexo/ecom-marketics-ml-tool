<template>
  <div v-if="order != null">
    <Chat
      :participants="participants"
      :myself="myself"
      :messages="messages"
      :on-type="onType"
      :on-message-submit="onMessageSubmit"
      :chat-title="chatTitle"
      :placeholder="placeholder"
      :colors="colors"
      :border-style="borderStyle"
      :hide-close-button="hideCloseButton"
      :close-button-icon-size="closeButtonIconSize"
      :submit-icon-size="submitIconSize"
      :load-more-messages="toLoad.length > 0 ? loadMoreMessages : null"
      :async-mode="asyncMode"
      :scroll-bottom="scrollBottom"
      :display-header="displayHeader"
    >
      <!-- <template v-slot:header>
        <div>
          <p v-for="(participant, index) in participants" :key="index" class="custom-title">
            {{ participant.name }}
          </p>
        </div>
      </template> -->
    </Chat>
  </div>
</template>

<script>
import { Chat } from 'vue-quick-chat'
import 'vue-quick-chat/dist/vue-quick-chat.css'

export default {
  name: 'ChatComponent',
  components: {
    Chat
  },
  props: {
    order: {
      type: Object
    }
  },
  data () {
    return {
      buyer_id: null,
      from: {
        current_ml_account: this.$store.state.auth.current_ml_account.ml_user_id,
        path: null,
        message: {
          from: {
            user_id: this.$store.state.auth.current_ml_account.ml_user_id,
            email: this.$store.state.auth.current_ml_account.ml_email
          },
          to:{
            user_id: null
          },
          text: null
        }
      },
      visible: false,
      conversation_status: null,
      participants: [
        {
          name: '',
          id: 1
        }

      ],
      myself: {
        name: '',
        id: parseInt(this.$store.state.auth.current_ml_account.ml_user_id)
      },
      messages: [

      ],
      chatTitle: '',
      placeholder: 'Enviar mensaje',
      colors: {
        header: {
          bg: '#7070c5',
          text: '#fff'
        },
        message: {
          myself: {
            bg: '#ececec',
            text: '#0e0e0e'
          },
          others: {
            bg: '#363636',
            text: '#fff'
          },
          messagesDisplay: {
            bg: '#1e1e1e'
          }
        },
        submitIcon: '#ffffff'
      },
      borderStyle: {
        topLeft: '10px',
        topRight: '10px',
        bottomLeft: '10px',
        bottomRight: '10px'
      },
      hideCloseButton: false,
      submitIconSize: '30px',
      closeButtonIconSize: '20px',
      asyncMode: false,
      toLoad: [
        // {
        //   content: 'Hey, John Doe! How are you today?',
        //   myself: false,
        //   participantId: 2,
        //   timestamp: { year: 2011, month: 3, day: 5, hour: 10, minute: 10, second: 3, millisecond: 123 },
        //   uploaded: true,
        //   viewed: true
        // }
      ],
      scrollBottom: {
        messageSent: true,
        messageReceived: false
      },
      displayHeader: true
    }
  },
  watch: {

    order: function (newVal, oldVal) {
      this.buyer_id = newVal.buyer_id
      this.messages = []
      this.conversation_status = JSON.parse(newVal.messages.conversation_status)
      console.log('Conversation Status', this.conversation_status)
      console.log('Messages', newVal)
      if (this.order != null) {
        var conversation = newVal.messages.conversation.reverse()
        this.chatTitle = newVal.title
        this.participants = [{ name: newVal.buyer_nickname, id: newVal.buyer_id }]
        conversation.forEach(msg => {
          var myself = false
          var participantId = parseInt(msg.from.user_id)
          if (parseInt(msg.from.user_id) === parseInt(this.$store.state.auth.current_ml_account.ml_user_id)) {
            myself = true
            if (msg.from.name != null) {
              this.myself.name = msg.from.name
            }
          } else {
            this.participants[0].id = participantId
          }
          this.messages.push({ content: msg.text, participantId: participantId, myself: myself })
          //    {
          //   content: 'received messages',
          //   myself: false,
          //   participantId: 1,
          //   timestamp: { year: 2019, month: 3, day: 5, hour: 20, minute: 10, second: 3, millisecond: 123 }
          // }
        })
        // console.log('Meesges', this.messages)
      }
    }
  },
  methods: {
    onType: function (event) {
      // here you can set any behavior
    },
    loadMoreMessages (resolve) {
      setTimeout(() => {
        resolve(this.toLoad) // We end the loading state and add the messages
        // Make sure the loaded messages are also added to our local messages copy or they will be lost
        this.messages.unshift(...this.toLoad)
        this.toLoad = []
      }, 1000)
    },
    onMessageSubmit: function (message) {
      /*
            * example simulating an upload callback.
            * It's important to notice that even when your message wasn't send
            * yet to the server you have to add the message into the array
            */
      console.log(message)
      this.from.path = this.conversation_status[0].path
      this.from.message.to.user_id = this.buyer_id
      this.from.message.text = message.content
      console.log('From', this.from)
      this.messages.push(message)

      /*
            * you can update message state after the server response
            */
      // timeout simulating the request
      setTimeout(() => {
        message.uploaded = true
      }, 2000)
    },
    onClose () {
      this.visible = false
    }
  }
}

</script>

<style>
.container-message-manager{
  background-color: #363636 !important;
}
.message-input{
  color: white !important;
}
.container-message-display{
  max-height: 63vh !important
}
</style>

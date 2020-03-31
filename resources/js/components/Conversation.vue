<template>
  <div v-if="msgDetail != null" class="col-md-12">
    <section ref="chatArea" class="chat-area">
      <p v-for="(message,index) in messages" :key="index" class="message" :class="{ 'message-out': message.author === 'you', 'message-in': message.author !== 'you' }">
        {{ message.body }}
      </p>
    </section>
    <div class="input-group mb-3">
      <input v-model="msgText" type="text" class="form-control" placeholder="Escribe un mensaje" aria-label="Escribe el mensaje" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" @click="respondQuestion">
          <i class="far fa-paper-plane" />
        </button>
      </div>
    </div>
    <div v-if="error.state == true" class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error: </strong> {{ error.msg }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
  <div v-else class="col-md-12">
    <h3 class="h3">
      No se a seleccionado ninguna pregunta
    </h3>
  </div>
</template>

<script>
import axios from 'axios'
let baseUrl = process.env.MIX_APP_URL
export default {
  name: 'Conversation',
  props: {
    // eslint-disable-next-line vue/require-default-prop
   
    msgDetail: {
      type: Object
    }
  },
  data () {
    return {
      clientMessage: '',
      youMessage: '',
      msgText: '',
      error: {
        state: false,
        msg: ''
      },
      messages: []
    }
  },
  watch: {
      	    msgDetail: function (newVal, oldVal) { // watch it
      console.log('Prop changed: ', newVal, ' | was: ', oldVal)
      if (newVal.answer == null) {
        this.messages.push({ body: newVal.text, author: 'Buyer name' })
      } else {
        this.messages.push({ body: newVal.text, author: 'Buyer name' })
        this.messages.push({ body: newVal.answer.text, author: 'you' })
      }

      //  axios
      // .get(baseUrl+'get-messages-by-id/'+ne
      // .then(response => (
      //     console.log('Success',response)
      //     ))
      // .catch(error => (console.log('Error: ',error)))
    }
  },
  methods: {
    respondQuestion () {
    //   var params = { 'question_id': this.msgDetail.id, 'text': this.msgText }
    //   axios.defaults.headers.common = {
    //     'X-Requested-With': 'XMLHttpRequest',
    //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //   }
    //   axios
    //     .post(baseUrl + 'respond-message-by-id', params)
    //     .then(response => (
    //       console.log('Success', response),
    //       this.validateRequest(response)
    //     ))
    //     .catch(error => (console.log('Error: ', error)))
    },
    validateRequest (request) {
      if (request.data.status == 400) {
        this.error.state = true
        this.error.msg = request.data.message
      } else {
        console.log('Se confirmo: ', request.data.answer.text)
        this.messages.push({ body: request.data.answer.text, author: 'you' })
      }
    },
    sendMessage (direction) {
      if (!this.youMessage && !this.clientMessage) {
        return
      }
      if (direction === 'out') {
        this.messages.push({ body: this.youMessage, author: 'you' })
        this.youMessage = ''
      } else if (direction === 'in') {
        this.messages.push({ body: this.clientMessage, author: 'bob' })
        this.clientMessage = ''
      } else {
        alert('something went wrong')
      }
      Vue.nextTick(() => {
        let messageDisplay = this.$refs.chatArea
        messageDisplay.scrollTop = messageDisplay.scrollHeight
      })
    },
    clearAllMessages () {
      this.messages = []
    }
  }
}
</script>

<style>

.headline {
  text-align: center;
  font-weight: 100;
  color: white;
}
.chat-area {
/*   border: 1px solid #ccc; */
  background: white;
  height: 50vh;
  padding: 1em;
  overflow: auto;
  /* max-width: 350px; */
  /* margin: 0 auto 2em auto; */
  box-shadow: 2px 2px 5px 2px rgba(0, 0, 0, 0.3)
}
.message {
  width: 45%;
  border-radius: 10px;
  padding: .5em;
/*   margin-bottom: .5em; */
  font-size: .8em;
}
.message-out {
  background: #407FFF;
  color: white;
  margin-left: 50%;
}
.message-in {
  background: #F1F0F0;
  color: black;
}
.chat-inputs {
  display: flex;
  justify-content: space-between;
}
#person1-input {
  padding: .5em;
}
#person2-input {
  padding: .5em;
}
</style>

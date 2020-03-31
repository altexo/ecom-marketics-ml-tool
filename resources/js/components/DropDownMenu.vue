<template>
  <v-menu
    v-model="value"
    :disabled="disabled"
    :absolute="absolute"
    :open-on-hover="openOnHover"
    :close-on-click="closeOnClick"
    :close-on-content-click="closeOnContentClick"
    :offset-x="offsetX"
    :offset-y="offsetY"
  >
    <template v-slot:activator="{ on }">
      <v-btn
        color="primary"
        dark
        text
        v-on="on"
      >
        <v-icon>mdi-account-circle</v-icon>
        <v-icon>mdi-menu-down</v-icon>
      </v-btn>
    </template>
    <v-list>
      <v-list-item
        v-for="(item, index) in items"
        :key="index"
        @click=""
      >
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  name: 'DropDownMenu',
  data: () => ({
    items: [
    ],
    disabled: false,
    absolute: false,
    openOnHover: false,
    value: false,
    closeOnClick: true,
    closeOnContentClick: true,
    offsetX: false,
    offsetY: true
  }),
  mounted () {
    // console.log(this.$store.state.auth.user.ml_accounts)
    this.$store.state.auth.user.ml_accounts.forEach(element => {
      console.log(element)
      this.items.push({ title: element.ml_user_id })
    })
  }
}
</script>

<style>

</style>

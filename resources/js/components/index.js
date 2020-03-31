import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import DropDownMenu from './DropDownMenu'
import { HasError, AlertError, AlertSuccess } from 'vform'
import ChatComponent from './ChatComponent'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  DropDownMenu,
  ChatComponent
].forEach(Component => {
  Vue.component(Component.name, Component)
})

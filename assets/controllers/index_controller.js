import { Controller } from '@hotwired/stimulus';
import { Application } from '@hotwired/stimulus'
import Clipboard from 'stimulus-clipboard'
import PasswordVisibility from 'stimulus-password-visibility'

const application = Application.start()
application.register('clipboard', Clipboard)
application.register('password-visibility', PasswordVisibility)


export default class extends Controller {

}

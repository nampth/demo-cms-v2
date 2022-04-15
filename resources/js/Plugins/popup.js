// we need our modal component
import PopupNotification from '@/Components/Toast';

export default{

    // every plugin for Vue.js needs install method

    // this method will run after Vue.use(<your-plugin-here>) is executed

    install(app, options) {
        app.component('popup-notification', PopupNotification)
        app.config.globalProperties.$popup = (params) => {
            // retrieve a nested property in `options`
            // using `key` as the path
            return key.split('.').reduce((o, i) => {
              if (o) return o[i]
            }, options)
          }
    }

}

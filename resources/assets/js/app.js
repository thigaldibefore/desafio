
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('modal-tarefas-component', require('./components/ModalTarefasComponent.vue').default);
Vue.component('feed-back-component', require('./components/FeedBackComponent.vue').default);
Vue.component('processos-component', require('./components/ProcessosComponent.vue').default);
Vue.component('list-tarefas-component', require('./components/ListaTarefasComponent.vue').default);
Vue.component('listahoras-component', require('./components/ListaHorasComponent.vue').default);
Vue.component('lista-anexo-processos-component', require('./components/ListaAnexosProcessosComponent.vue').default);


Vue.component('search-cliente', require('./components/widgets/SearchClienteComponent.vue').default);



/** COMPONENTS DUPLICADOS
 * INTERESSANTE UNIFICA LOS
 */
Vue.component('modal-attach-docs', require('./components/widgets/ModalAttachDocsComponent.vue').default);
Vue.component('modal-attach-docs-tarefas', require('./components/widgets/ModalAttachDocsTarefasComponent.vue').default);
Vue.component('modal-attach-docs-processos', require('./components/widgets/ModalAttachDocsProcessosComponent.vue').default);

/** **/


Vue.component('modal-clientes-component', require('./components/ModalClientesComponent.vue').default);
Vue.component('listagem-logs-component', require('./components/widgets/ListagemLogsComponent.vue').default);

Vue.component('finder-component', require('./components/widgets/FinderComponent.vue').default);
Vue.component('documentos-component', require('./components/DocumentosComponent.vue').default);

Vue.component('notification-component', require('./components/widgets/NotificationComponent.vue').default);

window.__UUID = function () {
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (dt + Math.random() * 16) % 16 | 0;
        dt = Math.floor(dt / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
    return uuid;
}


window.app = new Vue({
    el: '#app'
});
const ps = new PerfectScrollbar('.am-scroller-notifications');



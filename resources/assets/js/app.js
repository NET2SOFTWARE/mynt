
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

Vue.component(
    'example',
    require('./components/Example.vue')
);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);







Vue.component('industry-page', require('./components/app/admin/Industry.vue'));
Vue.component('country-page', require('./components/app/admin/Country.vue'));
Vue.component('state-page', require('./components/app/admin/State.vue'));
Vue.component('city-page', require('./components/app/admin/City.vue'));
Vue.component('identity-page', require('./components/app/admin/Identity.vue'));
Vue.component('partnership-page', require('./components/app/admin/Partnership.vue'));
Vue.component('partnership-create-page', require('./components/app/admin/Partnership-create.vue'));

Vue.component('administrator-page', require('./components/app/admin/Administrator.vue'));
Vue.component('administrator-super-page', require('./components/app/admin/Administrator-super.vue'));
Vue.component('administrator-admin-page', require('./components/app/admin/Administrator-admin.vue'));


Vue.component('transaction-page', require('./components/app/admin/Transaction.vue'));
Vue.component('transaction-success-page', require('./components/app/admin/TransactionSuccess.vue'));
Vue.component('transaction-refund-page', require('./components/app/admin/TransactionRefund.vue'));
Vue.component('transaction-failed-page', require('./components/app/admin/TransactionFailed.vue'));
Vue.component('company-page', require('./components/app/admin/Company.vue'));
Vue.component('merchant-page', require('./components/app/admin/Merchant.vue'));
Vue.component('merchant-group-page', require('./components/app/admin/MerchantGroup.vue'));
Vue.component('merchant-individual-page', require('./components/app/admin/MerchantIndividual.vue'));
Vue.component('member-page', require('./components/app/admin/Member.vue'));


const app = new Vue({
    el: '#app'
});

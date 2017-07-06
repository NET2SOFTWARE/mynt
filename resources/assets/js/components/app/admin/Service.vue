<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <transition name="fade">
        <section v-if="page_show" class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
            <section class="header-content justify-content-between align-items-baseline">
                <section>
                    <p class="medium lh-1-5 mb-0">SERVICE</p>
                </section>
                <section class="d-flex justify-content-between align-content-st align-items-baseline">
                    <section class="d-flex justify-content-between align-content-start">
                        <section class="btn-group btn-group-sm mr-3">
                            <button type="button" class="btn btn-secondary" @click="showCreateServiceForm">New</button>
                        </section>
                        <section class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-secondary">Print</button>
                            <button v-on:click="show = !show; getServices()" type="button" class="btn btn-secondary">Refresh</button>
                        </section>
                    </section>
                    <section class="input-group input-group-sm ml-3">
                        <section class="input-group-btn">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Category
                            </button>
                            <section class="dropdown-menu">
                                <a class="dropdown-item" href="#">ID</a>
                                <a class="dropdown-item" href="#">Name</a>
                                <section role="separator" class="dropdown-sectionider"></section>
                                <a class="dropdown-item" href="#">State name</a>
                                <a class="dropdown-item" href="#">Country name</a>
                            </section>
                        </section>
                        <input id="search" name="search" type="search" class="form-control" placeholder="Search value" style="max-width:160px!important;width:160px!important;">
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Find</button>
                    </span>
                    </section>
                    <section class="btn-group btn-group-sm ml-3">
                        <button v-on:click="fetchServices(pagination.prev_page_url); show = !show" :disabled="!pagination.prev_page_url" type="button" class="btn btn-secondary">Previous</button>
                        <button v-on:click="fetchServices(pagination.next_page_url); show = !show" :disabled="!pagination.next_page_url" type="button" class="btn btn-secondary">Next</button>
                    </section>
                </section>
            </section>
            <transition name="fade">
                <section class="table-sm table-responsive medium p-3" v-if="services.length > 0 && show">
                    <table class="table">
                        <thead>
                        <tr class="medium">
                            <th>ID</th>
                            <th>DATE</th>
                            <th>NAME</th>
                            <th>STATE</th>
                            <th>COUNTRY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="service in services">
                            <td>{{ service.id }}</td>
                            <td>{{ service.created_at }}</td>
                            <td>{{ service.name }}</td>
                            <td>{{ service.state.name }}</td>
                            <td>{{ service.state.country.name }}</td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            </transition>
        </section>
    </transition>


    <!-- Edit service modal form -->
    <section class="modal fade" id="serviceAddModal" tabindex="-1" role="dialog" aria-labelledby="serviceAddModalLabel" aria-hidden="true">
        <section class="modal-dialog" role="document">
            <section class="modal-content">
                <section class="modal-header">
                    <h5 class="modal-title" id="serviceAddModalLabel">Add new service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </section>
                <section class="modal-body">
                    <section class="alert alert-danger" v-if="editForm.errors.length > 0">
                        <ul><li v-for="error in editForm.errors">{{ error }}</li></ul>
                    </section>
                    <form role="form" accept-charset="utf-8">
                        <fieldset class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="nameAdd" class="form-control" v-model="createFrom.name" aria-describedby="nameAddHelpBlock">
                            <p id="nameAddHelpBlock" class="form-text text-muted">Service name must be 4-40 characters long, contain letters and numbers</p>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="charge">Charge</label>
                            <input type="text" id="chargeAdd" class="form-control" v-model="createFrom.charge" aria-describedby="chargeAddHelpBlock">
                            <p id="chargeAddHelpBlock" class="form-text text-muted">Service charge must numbers only</p>
                        </fieldset>
                    </form>
                </section>
                <section class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="store" role="button">Save</button>
                </section>
            </section>
        </section>
    </section>



    <!-- Edit service modal form -->
    <section class="modal fade" id="serviceEditModal" tabindex="-1" role="dialog" aria-labelledby="serviceEditModalLabel" aria-hidden="true">
        <section class="modal-dialog" role="document">
            <section class="modal-content">
                <section class="modal-header">
                    <h5 class="modal-title" id="serviceEditModalLabel">Add new service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </section>
                <section class="modal-body">
                    <section class="alert alert-danger" v-if="editForm.errors.length > 0">
                        <ul><li v-for="error in editForm.errors">{{ error }}</li></ul>
                    </section>
                    <form role="form" accept-charset="utf-8">
                        <fieldset class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" v-model="editForm.name" aria-describedby="nameHelpBlock">
                            <p id="nameHelpBlock" class="form-text text-muted">
                                Service name must be 4-40 characters long, contain letters and numbers
                            </p>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="charge">Charge</label>
                            <input type="text" id="charge" class="form-control" v-model="editForm.charge" aria-describedby="chargeHelpBlock">
                            <p id="chargeHelpBlock" class="form-text text-muted">
                                Service charge must numbers only
                            </p>
                        </fieldset>
                    </form>
                </section>
                <section class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update" role="button">Save</button>
                </section>
            </section>
        </section>
    </section>
</template>

<script>
    export default {

        data() {
            return {
                services : [],
                pagination: {},
                show: false,
                page_show: false,

                createForm: {
                    errors: [],
                    name: '',
                    charge: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    charge: ''
                }
            };
        },

        mounted() {
            this.prepareComponent();
        },

        methods: {

            prepareComponent() {
                this.getServices();
                this.page_show = true;

                $('#serviceAddModal').on('shown.bs.modal', () => {
                    $('#name').focus();
                });

                $('#serviceEditModal').on('shown.bs.modal', () => {
                    $('#name').focus();
                });
            },

            getServices() {
                axios.get('/api/service')
                    .then((response) => {
                        this.services = response.data.services.data;
                        this.makePagination(response.data.services);
                        this.show = true;
                    });
            },

            fetchServices(page_url) {
                let vm = this;
                page_url = page_url || '/api/service';
                axios.get(page_url)
                    .then((response) => {
                        vm.makePagination(response.data.services);
                        vm.services = response.data.services.data;
                        vm.show = true;
                    });
            },

            makePagination: function(data){
                let pagination = {
                    current_page : data.current_page,
                    last_page : data.last_page,
                    next_page_url : data.next_page_url,
                    prev_page_url : data.prev_page_url
                };

                this.pagination = pagination;
            },




            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                $('#serviceAddModal').modal('show');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/api/service',
                    this.createForm, '#serviceAddModal'
                );
            },

            /**
             * Edit the given client.
             */
            edit(service) {
                this.editForm.id        = service.id;
                this.editForm.name      = service.name;
                this.editForm.charge    = service.charge.amount;

                $('#serviceEditModal').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/api/service/' + this.editForm.id,
                    this.editForm, '#serviceEditModal'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getServices();

                        form.name = '';
                        form.charge = '';
                        form.errors = [];

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(service) {
                axios.delete('/api/service/' + service.id)
                    .then((response) => {
                        this.getServices();
                    });
            }
        }
    }
</script>
<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <transition name="fade">
        <section v-if="page_show" class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2 p-0">
            <section class="header-content justify-content-between align-items-baseline">
                <section>
                    <p class="medium lh-1-5 mb-0">STATE</p>
                </section>
                <section class="d-flex justify-content-between align-items-baseline">
                    <section class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-secondary">Print</button>
                        <button v-on:click="show = !show; getStates()" type="button" class="btn btn-secondary">Refresh</button>
                    </section>
                    <section class="input-group input-group-sm ml-4">
                        <section class="input-group-btn">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                category
                            </button>
                            <section class="dropdown-menu medium-small">
                                <a class="dropdown-item" href="#">Name</a>
                                <a class="dropdown-item" href="#">ISO</a>
                                <a class="dropdown-item" href="#">Currency</a>
                                <section role="separator" class="dropdown-divider"></section>
                                <a class="dropdown-item" href="#">State name</a>
                            </section>
                        </section>
                        <input id="search" name="search" type="search" class="form-control" placeholder="Search value" style="max-width:160px!important;width:160px!important;">
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Find</button>
                    </span>
                    </section>
                    <section class="btn-group btn-group-sm ml-3">
                        <button v-on:click="fetchCities(pagination.prev_page_url); show = !show" :disabled="!pagination.prev_page_url" type="button" class="btn btn-secondary">Previous</button>
                        <button v-on:click="fetchCities(pagination.next_page_url); show = !show" :disabled="!pagination.next_page_url" type="button" class="btn btn-secondary">Next</button>
                    </section>
                </section>
            </section>
            <transition name="fade">
                <section class="table-sm table-responsive medium p-3" v-if="states.length > 0 && show">
                    <table class="table">
                        <thead>
                        <tr class="medium">
                            <th>ID</th>
                            <th>NAME</th>
                            <th>COUNTRY</th>
                            <th class="text-center">ISO - COUNTRY</th>
                            <th class="text-center">TOTAL CITY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="state in states">
                            <td>{{ state.id }}</td>
                            <td>{{ state.name }}</td>
                            <td>{{ state.country.name }}</td>
                            <td class="text-center">{{ state.country.iso }}</td>
                            <td class="text-center">{{ state.city.length }}</td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            </transition>
        </section>
    </transition>
</template>

<script>
    export default {

        data() {
            return {
                states : [],
                pagination: {},
                show: false,
                page_show : false
            };
        },

        mounted() {
            this.prepareComponent();
        },

        methods: {

            prepareComponent() {
                this.getStates();
                this.page_show = true;
            },

            getStates() {
                axios.get('/api/state')
                    .then((response) => {
                        this.states = response.data.states.data;
                        this.makePagination(response.data.states);
                        this.show = true;
                    });
            },

            fetchCities(page_url) {
                let vm = this;
                page_url = page_url || '/api/state';
                axios.get(page_url)
                    .then((response) => {
                        vm.makePagination(response.data.states);
                        vm.states = response.data.states.data;
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
            }
        }
    }
</script>
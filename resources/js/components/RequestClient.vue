<template>
    <div class="suggest-search-input mb-1" v-if="!client">
        <b-input-group>
            <b-form-input type="text" name="client_email" v-model="keyword" @input="search_clients"
                          autocomplete="off" placeholder="email">
            </b-form-input>
            <input type="hidden" name="client_id" v-model="client_id" value="0">
            <b-input-group-append>
                <a class="btn btn-secondary" href="/customers/customer/0" v-b-tooltip.hover title="Add new customer"
                   target="_blank">
                    <b-icon icon="plus"></b-icon>
                </a>
            </b-input-group-append>
        </b-input-group>
        <div class="suggest-list" v-if="keyword.length > 0">
            <div class="loading-icon" v-if="search_loading"></div>
            <div class="sbd-table sbd-table-light" v-if="client_results && client_results.length > 0">
                <div class="sbd-row" v-for="client in client_results"
                     v-on:click="set_client(client)">
                    <div class="cell">{{client.email}}</div>
                    <div class="cell cell-7">{{client.name}}</div>
                    <div class="cell cw-50">
                        <b-icon icon="chevron-bar-up"></b-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RequestClient",
        props: ['vars'],
        data() {
            return {
                keyword: this.vars.client_email || '',
                client_results: null,
                search_loading: false,
                client_id: this.vars.client_id || 0,
                client: null
            }
        },
        methods: {
            search_clients: function () {
                this.client_results = null
                this.search_loading = true
                setTimeout(function () {
                    this.get_data('/customers/search/' + this.keyword, true)
                        .then(response => {
                            if (typeof response === 'object') {
                                this.client_results = response
                            }
                        })
                        .catch(reason => this.errors.push(reason.message))
                        .finally(() => {
                            this.search_loading = false
                        })
                }.bind(this), 500)
            },
            set_client: function (client) {
                this.keyword = client.email
                this.client_id = client.id
                this.client_results = null
            }
        }
    }
</script>

<template>
    <div class="clearfix mt-4">
        <div class="suggest-search-input">
            <b-input-group prepend="Search requests" append="">
                <b-form-input type="text" name="request_name" v-model="keyword" maxlength="20"
                              @input="search_requests"
                              autocomplete="off" placeholder="...">
                </b-form-input>
            </b-input-group>
            <div class="suggest-list" v-if="keyword.length > 0">
                <div class="loading-icon" v-if="search_loading"></div>
                <div class="sbd-table sbd-table-light" v-if="request_results && request_results.length > 0">
                    <div class="sbd-row" v-for="s_request in request_results"
                         v-on:click="add_request(s_request)" :key="s_request.id">
                        <div class="cell">{{s_request.name}}</div>
                        <div class="cell cw-50">
                            <b-icon icon="plus"></b-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sbd-table shadow-2 mt-2">
            <div class="sbd-row header">
                <div class="cell">
                    <h3 style="display: inline">Requests</h3>
                </div>
                <div class="cell cw-50 cell-7"></div>
            </div>
            <div class="sbd-row" v-for="request in requests" :key="request.id">
                <div class="cell">
                    <a :href="'/requests/request/' + request.id" target="_blank">
                        {{request.name}}
                    </a>
                </div>
                <div class="cell cell-7">
                    <b-icon icon="x" class="text-danger" v-on:click="remove_request(request.id)"></b-icon>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProblemRequests",
        props: ['vars'],
        data() {
            return {
                keyword: '',
                request_results: null,
                requests: this.vars.requests || [],
                search_loading: false
            }
        },
        methods: {
            search_requests: function () {
                this.search_loading = true
                setTimeout(function () {
                    this.get_data('/requests/search/' + this.keyword, true)
                        .then(response => {
                            if (typeof response === 'object') {
                                this.request_results = response
                            }
                        })
                        .catch(reason => this.errors.push(reason.message))
                        .finally(() => {
                            this.search_loading = false
                        })
                }.bind(this), 500)
            },
            add_request: function (solution) {
                let add = 1;
                this.keyword = ''
                this.request_results = null

                this.requests.forEach(function (s) {
                    if (s.id === solution.id) {
                        this.make_toast('danger', 'Failed', 'Duplicate')
                        add = 0
                    }
                }.bind(this))
                if (add === 1) {
                    this.requests.push(solution)
                    let data = {id: this.vars.id, requests: this.requests}
                    this.post_data('/problems/add-requests', data)
                        .then(response => {
                            if (typeof response === 'object') {
                                if (response.status === true) {

                                    this.make_toast('success', 'Successful', response.message)
                                }
                                else {
                                    this.make_toast('danger', 'Failed', response.message)
                                }
                            }
                        })
                        .catch(reason => this.make_toast('danger', 'Failed', reason.message))
                }
            },
            remove_request: function (remove_id) {
                this.$bvModal.msgBoxConfirm('Are you sure?', {centered: true})
                    .then(value => {
                        if (value) {
                            let data = {id: this.vars.id, requests: this.requests, remove_id}
                            this.post_data('/problems/remove-request', data)
                                .then(response => {
                                    if (typeof response === 'object') {
                                        if (response.status === true) {
                                            this.make_toast('success', 'Successful', response.message)
                                            let i = 0
                                            while (i < this.requests.length) {
                                                if (this.requests[i].id === remove_id) {
                                                    this.requests.splice(i, 1)
                                                } else {
                                                    i++
                                                }
                                            }
                                        }
                                        else {
                                            this.make_toast('danger', 'Failed', response.message)
                                        }
                                    }
                                })
                                .catch(reason => this.make_toast('danger', 'Failed', reason.message))
                        }
                    })
            }
        }
    }
</script>
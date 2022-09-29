<template>
    <div class="clearfix mt-4">
        <div class="suggest-search-input">
            <b-input-group prepend="Search knowledge" append="">
                <b-form-input type="text" name="solution_name" v-model="keyword" maxlength="20"
                              @input="search_solutions"
                              autocomplete="off" placeholder="...">
                </b-form-input>
            </b-input-group>
            <div class="suggest-list" v-if="keyword.length > 0">
                <div class="loading-icon" v-if="search_loading"></div>
                <div class="sbd-table sbd-table-light" v-if="solution_results && solution_results.length > 0">
                    <div class="sbd-row" v-for="s_solution in solution_results"
                         v-on:click="add_solution(s_solution)" :key="s_solution.id">
                        <div class="cell">{{s_solution.name}}</div>
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
                    <h3 style="display: inline">Knowledge for handle</h3>
                </div>
                <div class="cell cw-50 cell-7"></div>
            </div>
            <div class="sbd-row" v-for="solution in solutions" :key="solution.id">
                <div class="cell">
                    <a :href="'/solutions/solution/' + solution.id" target="_blank">
                        {{solution.name}}
                    </a>
                </div>
                <div class="cell cell-7">
                    <b-icon icon="x" class="text-danger" v-on:click="remove_solution(solution.id)"></b-icon>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RequestSolutions",
        props: ['vars'],
        data() {
            return {
                keyword: '',
                solution_results: null,
                solutions: this.vars.solutions || [],
                search_loading: false,
                type: this.vars.type || 'Request'
            }
        },
        methods: {
            search_solutions: function () {
                this.search_loading = true
                setTimeout(function () {
                    this.get_data('/solutions/search/' + this.keyword, true)
                        .then(response => {
                            if (typeof response === 'object') {
                                this.solution_results = response
                            }
                        })
                        .catch(reason => this.errors.push(reason.message))
                        .finally(() => {
                            this.search_loading = false
                        })
                }.bind(this), 500)
            },
            add_solution: function (solution) {
                let add = 1;
                this.keyword = ''
                this.solution_results = null

                this.solutions.forEach(function (s) {
                    if (s.id === solution.id) {
                        this.make_toast('danger', 'Failed', 'Duplicate')
                        add = 0
                    }
                }.bind(this))
                if (add === 1) {
                    this.solutions.push(solution)
                    let data = {id: this.vars.id, solutions: this.solutions}
                    let url = this.type === 'Problem' ? '/problems/add-solutions' : '/requests/add-solutions'
                    this.post_data(url, data)
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
            remove_solution: function (remove_id) {
                this.$bvModal.msgBoxConfirm('Are you sure?', {centered: true})
                    .then(value => {
                        if (value) {
                            let data = {id: this.vars.id, solutions: this.solutions, remove_id}
                            let url = this.type === 'Problem' ? '/problems/remove-solution' : '/requests/remove-solution'
                            this.post_data(url, data)
                                .then(response => {
                                    if (typeof response === 'object') {
                                        if (response.status === true) {
                                            this.make_toast('success', 'Successful', response.message)
                                            let i = 0
                                            while (i < this.solutions.length) {
                                                if (this.solutions[i].id === remove_id) {
                                                    this.solutions.splice(i, 1)
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
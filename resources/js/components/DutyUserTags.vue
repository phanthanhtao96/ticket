<template>
    <div class="suggest-search-input mb-1">
        <div class="w-100 mb-1 text-left">
            <b-badge variant="info" class="mr-2" v-for="email in users" :key="email">{{email}} <i
                    class="fa fa-times ml-1" aria-hidden="true" v-on:click="remove_user(email)"></i></b-badge>
        </div>
        <input type="hidden" :name="vars.input_name" v-model="users">
        <b-form-input type="text" name="" v-model="keyword" maxlength="20" @input="search_users"
                      autocomplete="off" placeholder="email, name, phone...">
        </b-form-input>
        <div class="suggest-list" v-if="keyword.length > 0">
            <div class="loading-icon" v-if="search_loading"></div>
            <div class="sbd-table sbd-table-light" v-if="user_results && user_results.length > 0">
                <div class="sbd-row" v-for="user in user_results"
                     v-on:click="add_user(user.email)">
                    <div class="cell"><p class="mb-0">{{user.email}}</p><span class="small">{{user.name}}</span></div>
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
        name: "DutyUserTags",
        props: ['vars'],
        data() {
            return {
                keyword: '',
                user_results: null,
                search_loading: false,
                users: this.vars.users || [],
                users_string: ''
            }
        },
        methods: {
            search_users: function () {
                this.user_results = null
                this.search_loading = true
                setTimeout(function () {
                    this.get_data('/users/search/' + this.keyword, true)
                        .then(response => {
                            if (typeof response === 'object') {
                                this.user_results = response
                            }
                        })
                        .catch(reason => this.errors.push(reason.message))
                        .finally(() => {
                            this.search_loading = false
                        })
                }.bind(this), 500)
            },
            add_user: function (email) {
                if (this.users.includes(email))
                    this.make_toast('danger', 'Failed', 'Duplicate')
                else {
                    this.users.push(email)
                    this.keyword = ''
                    this.user_results = null
                }
            },
            remove_user: function (email) {
                let i = 0
                while (i < this.users.length) {
                    if (this.users[i] === email) {
                        this.users.splice(i, 1)
                    } else {
                        i++
                    }
                }
            }
        }
    }
</script>
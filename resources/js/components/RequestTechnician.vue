<template>
    <div>
        <b-form-group label="Company (*)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <select class="custom-select" name="company_id" v-model="company_id"
                    v-on:change="get_users(); technician_id = 0">
                <option :value="init_company_id">---</option>
                <option v-for="c in vars.companies" :value="c.id">
                    {{c.name}}
                </option>
            </select>

        </b-form-group>
        <b-form-group label="Group"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <select class="custom-select" name="group_id" v-model="group_id"
                    v-on:change="get_users(1)">
                <option :value="init_group_id">---</option>
                <option v-for="group in vars.groups" :value="group.id">
                    {{group.name}}
                </option>
            </select>
        </b-form-group>
        <b-form-group label="Technician (*)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <select class="custom-select" name="technician_id" v-model="technician_id"
                    v-on:change="get_user(1)">
                <option :value="init_technician">---</option>
                <option v-for="user in users" :value="user.id">
                    {{user.name}}
                </option>
            </select>
            <input type="hidden" name="technician_email" maxlength="50" minlength="8"
                   :value="technician ? technician.email : ''">
            <input type="hidden" name="" :value="technician ? technician.department_name : ''">
            <input type="hidden" name="" maxlength="3" minlength="100" :value="technician ? technician.job_title : ''">
            <input type="hidden" name="" :value="technician ? technician.phone : ''">
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "RequestTechnician",
        props: ['vars'],
        data() {
            return {
                users: [],
                company_id: this.vars.request.company_id || 0,
                group_id: this.vars.request.group_id || 0,
                technician_id: this.vars.technician.id || 0,
                technician: this.vars.technician || null,
                init_technician: '',
                init_company_id: '',
                init_group_id: ''
            }
        },
        created: function () {
            this.get_users()
        },
        methods: {
            get_users: function (selection = 0) {
                if (selection === 1) this.technician_id = 0
                this.technician = null
                this.get_data('/users/list-json/' + this.company_id + '/' + this.group_id, true)
                    .then((response) => {
                            if (typeof response !== 'object')
                                this.errors.push('Error')
                            else
                                this.users = response
                        }
                    )
                    .catch(reason => this.errors.push(reason.message))
                    .finally(() => {
                        this.get_user()
                    })
            },
            get_user: function () {
                this.get_data('/users/user-json/' + this.technician_id, true)
                    .then((response) => {
                            if (typeof response !== 'object')
                                this.errors.push('Error')
                            else
                                this.technician = response
                        }
                    )
                    .catch(reason => this.errors.push(reason.message))
            }
        }
    }
</script>

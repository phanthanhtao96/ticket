<template>
    <div>
        <!--List-->
        <div class="sbd-table mb-2" v-if="rules">
            <div class="sbd-row" v-for="(rule, rule_key) in rules" :key="rule_key">
                <div v-if="Object.keys(rule.cc).length > 0" class="cell bg-light">
                  <b>{{rule.time_type + ' ' + rule.difference_time + ' minutes :'}}</b> {{rule.email_type}} to {{!Object.keys(rule.cc).length ? 'undefined' : rule.cc.join()}}
                </div>
                <div v-else class="cell bg-light">
                  Do not set mail to scalate
                </div>
                <div class="cell cw-50">
                    <i class="fa fa-trash-o text-danger" aria-hidden="true" v-on:click="del_rule(rule_key)"></i>
                </div>
                <div class="cell cw-50">
                    <i class="fa fa-pencil-square-o" aria-hidden="true" v-on:click="edit_rule(rule_key)"></i>
                </div>
            </div>
        </div>
        <!---->
        <div class="w-100 text-right">
            <b-button variant="success" v-on:click="new_rule">New rule</b-button>
        </div>

        <!--Rule edit-->
        <b-modal v-model="rule_edit" :centered="true" title="Rule">
          <b-form-group label="Escalate to"
                        label-cols="12" label-cols-md="4" label-cols-xl="3"
                        label-class="text-secondary">
            <user-tags :vars="{users: cc, input_name: 'l' + vars.level + '_cc'}"></user-tags>
          </b-form-group>
            <b-form-group v-if="rule_type === 'Resolve'" label="Level"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <b-form-input type="number" v-model="level" name="level" min="2" max="4" disabled>
                </b-form-input>
            </b-form-group>

            <b-form-group v-if="rule_type === 'Resolve'" label="Time (Minutes)"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
<!--                <b-alert class="same-width" variant="warning" show>compare to escalate time</b-alert>-->

                <div class="datetime-input-wrap">
                    <div class="input-wrap">
                        <select class="custom-select" name="time_type" v-model="time_type">
                            <option v-for="key in vars.time_types" :value="key">
                                {{key}}
                            </option>
                        </select>
                    </div>
                    <div class="input-wrap">
                        <b-form-input type="number" name="difference_time" v-model="difference_time" value=""
                                      :readonly="time_type==='Equal'"
                                      placeholder="minutes" min="0"
                                      max="100000">
                        </b-form-input>
                    </div>
                </div>
            </b-form-group>
            <b-form-group v-if="rule_type === 'Response'" label="Time (Minutes)"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <div class="datetime-input-wrap">
                    <div class="input-wrap">
                        <select class="custom-select" name="time_type" v-model="time_type">
                            <option v-for="key in vars.time_types" :value="key">
                                {{key}}
                            </option>
                        </select>
                    </div>
                    <div class="input-wrap">
                        <b-form-input type="number" name="difference_time" v-model="difference_time" value=""
                                      :readonly="time_type==='Equal'"
                                      placeholder="minutes" min="0"
                                      max="100000">
                        </b-form-input>
                    </div>
                </div>
            </b-form-group>


            <b-form-group label="Action"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <select class="custom-select" name="action" v-model="action">
                    <option v-for="key in vars.actions" :value="key">
                        {{key}}
                    </option>
                </select>
            </b-form-group>
            <b-form-group label="Email"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <select class="custom-select" name="action" v-model="email_type">
                    <option v-for="key in vars.email_types" :value="key">
                        {{key}}
                    </option>
                </select>
            </b-form-group>
            <b-form-group label="Assign to"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <select class="custom-select" name="" v-model="role_type">
                    <option v-for="(role, key) in vars.role_types" :value="key">
                        {{role}}
                    </option>
                </select>
            </b-form-group>

            <template v-slot:modal-footer>
                <div class="w-100">
                    <b-button variant="danger" v-on:click="rule_edit = !rule_edit">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </b-button>
                    <b-button variant="success" v-on:click="update_rule">{{rule_edit_button_label}}</b-button>
                </div>
            </template>
        </b-modal>
        <!---->
    </div>
</template>

<script>
    export default {
        name: "SLARuler",
        props: ['vars'],
        data() {
            return {
                rule_type: this.vars.rule_type || '',
                rule_id: '',
                level: this.vars.level || 1,
                time_type: this.vars.time_type || '',
                difference_time: this.vars.difference_time || 0,
                action: this.vars.action || '',
                email_type: this.vars.email_type || '',
                role_type: this.vars.role_type || '',
                cc: this.vars.rules.cc || [],
                rules: this.vars.rules || [],
                rule_edit_button_label: 'Add',
                rule_edit: false
            }
        },
        methods: {
            update_rule: function () {
                let data = {
                    id: this.vars.sla_id,
                    data_column: this.vars.data_column,
                    rule_id: this.rule_id,
                    level: this.level,
                    time_type: this.time_type,
                    difference_time: this.difference_time,
                    action: this.action,
                    email_type: this.email_type,
                    role_type: this.role_type,
                    cc: this.cc
                }
                this.post_data('/sla/update-rule', data)
                    .then(response => {
                        if (typeof response === 'object') {
                            if (response.status === true) {
                                this.make_toast('success', 'Successful', response.message)
                                this.rule_edit = false
                                this.get_rules()
                            }
                            else {
                                this.make_toast('danger', 'Failed', response.message)
                            }
                        }
                    })
                    .catch(reason => this.make_toast('danger', 'Failed', reason.message))
            },
            new_rule: function () {
                this.rule_id = ''
                this.level = this.vars.level || 2
                this.time_type = this.vars.time_type || ''
                this.difference_time = this.vars.difference_time || 0
                this.action = this.vars.action || ''
                this.email_type = this.vars.email_type || ''
                this.role_type = this.vars.role_type || ''
                this.cc = []
                this.rule_edit_button_label = 'Add'
                this.rule_edit = true
            },
            edit_rule: function (key) {
                this.get_data('/sla/get-rule-json/' + this.vars.sla_id + '/' + this.vars.data_column + '/' + key, true)
                    .then(response => {
                        if (typeof response === 'object') {
                            this.rule_id = key
                            this.level = response.level
                            this.time_type = response.time_type
                            this.difference_time = response.difference_time
                            this.action = response.action
                            this.email_type = response.email_type
                            this.role_type = response.role_type
                            this.cc = response.cc
                            this.rule_edit_button_label = 'Update'
                            this.rule_edit = true
                        }
                    })
                    .catch(reason => this.errors.push(reason.message))
            },
            del_rule: function (key) {

                this.$bvModal.msgBoxConfirm('Are you sure?', {centered: true})
                    .then(value => {
                        if (value) {
                            this.get_data('/sla/del-rule/' + this.vars.sla_id + '/' + this.vars.data_column + '/' + key, true)
                                .then(response => {
                                    if (response.status === true) {
                                        this.make_toast('success', 'Successful', response.message)
                                        this.get_rules()
                                    }
                                    else {
                                        this.make_toast('danger', 'Failed', response.message)
                                    }
                                })
                                .catch(reason => this.errors.push(reason.message))
                        }
                    })
            },

            get_rules: function () {
                this.get_data('/sla/get-rules-json/' + this.vars.sla_id + '/' + this.vars.data_column, true)
                    .then(response => {
                        if (typeof response === 'object') {
                            this.rules = response
                        }
                    })
                    .catch(reason => this.errors.push(reason.message))
            }
        }
    }
</script>

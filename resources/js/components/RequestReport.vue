<template>
    <b-form method="post" action="/report">
        <b-card no-body class="shadow-2 mb-3">
            <template #header>
                <h2 class="mb-0">Report options</h2>
            </template>
            <b-card-body>
                <b-row>
                    <b-col cols="12" class="mb-3">
                        <div class="checkbox-list-2">
                            <div class="check-row" v-for="request_report_field in vars.request_report_fields"
                                 :key="request_report_field.key">
                                <b-form-checkbox v-model="selectedLocations" name="columns[]"
                                                 :value="request_report_field.key">
                                    {{request_report_field.key}}. {{request_report_field.name}}
                                </b-form-checkbox>
                            </div>
                        </div>
                    </b-col>
                    <b-col cols="12" lg="8">
                        <div class="hr-radius"></div>
                        <b-form-group label="Date filter"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="date_range" v-model="date_range">
                                <option v-for="request_report_field in vars.request_report_fields"
                                        :value="request_report_field.key" v-if="request_report_field.type==='DateTime'">
                                    {{request_report_field.name}}
                                </option>
                            </select>
                        </b-form-group>
                        <b-form-group label="From"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <div class="datetime-input-wrap">
                                <div class="input-wrap">
                                    <b-input type="date" name="from_date" v-model="from_date" maxlength="12"></b-input>
                                </div>
                                <div class="input-wrap">
                                    <b-input type="time" name="from_time" v-model="from_time" maxlength="8"></b-input>
                                </div>
                            </div>
                        </b-form-group>
                        <b-form-group label="To"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <div class="datetime-input-wrap">
                                <div class="input-wrap">
                                    <b-input type="date" name="to_date" v-model="to_date" maxlength="12"></b-input>
                                </div>
                                <div class="input-wrap">
                                    <b-input type="time" name="to_time" v-model="to_time" maxlength="8"></b-input>
                                </div>
                            </div>
                        </b-form-group>
                        <div class="hr-radius"></div>
                      <b-form-group label="Requester"
                                    label-cols="12" label-cols-md="4" label-cols-xl="3"
                                    label-class="text-secondary">
                        <select class="custom-select" name="request_by" v-model="request_by">
                          <option value="All">All</option>
                          <option v-for="(value, key) in vars.users" :value="key">{{value}}</option>
                        </select>
                      </b-form-group>
                      <b-form-group label="Assigned to"
                                    label-cols="12" label-cols-md="4" label-cols-xl="3"
                                    label-class="text-secondary">
                        <select class="custom-select" name="technician_id" v-model="technician_id">
                          <option value="All">All</option>
                          <option v-for="(value, key) in vars.users" :value="key">{{value}}</option>
                        </select>
                      </b-form-group>
                        <b-form-group label="Status"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="status-multiselect" name="status[]" v-model="status" multiple="multiple">
                                <option value="All">All</option>
                                <option v-for="(value, key) in vars.request_status" :value="key">{{value}}</option>
                            </select>
                        </b-form-group>
                        <b-form-group label="Overdue status"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="overdue_status" v-model="overdue_status">
                                <option value="All">All</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </b-form-group>
                        <div class="hr-radius"></div>
                        <b-form-group label="Sort by"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="sort_by" v-model="sort_by">
                                <option v-for="request_report_field in vars.request_report_fields"
                                        :value="request_report_field.key" v-if="request_report_field.type!==''">
                                    {{request_report_field.name}}
                                </option>
                            </select>
                        </b-form-group>
                        <b-form-group label="Sort type"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="sort_type" v-model="sort_type">
                                <option value="asc">A-Z (1-9)</option>
                                <option value="desc">Z-A (0-1)</option>
                            </select>
                        </b-form-group>
                        <div class="hr-radius"></div>
                        <b-form-group label="Request ID"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <b-form-input name="request_id" v-model="request_id" rows="2"
                                             maxlength="2000"
                                             spellcheck="false">
                            </b-form-input>
                        </b-form-group>
                        <b-form-group label="SLA"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="sla_id"
                                    v-model="sla">
                                <option value="">---</option>
                                <option v-for="sla in vars.slas"
                                        :value="sla.id">
                                    {{sla.name}}
                                </option>
                            </select>
                        </b-form-group>
                        <b-form-group label="Priority"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="priority_id"
                                    v-model="priority_id">
                                <option value="">---</option>
                                <option v-for="priority in vars.priorities"
                                        :value="priority.id">
                                    {{priority.name}}
                                </option>
                            </select>
                        </b-form-group>
                        <b-form-group label="Email khách hàng"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <b-form-input name="client_email" v-model="client_email" rows="2"
                                          maxlength="2000"
                                          spellcheck="false">
                            </b-form-input>
                        </b-form-group>
                        <b-form-group label="TAC case number"
                                                     label-cols="12" label-cols-md="4" label-cols-xl="3"
                                                     label-class="text-secondary">
                            <b-form-input name="tac_number" v-model="tac_number" rows="2"
                                          maxlength="2000"
                                          spellcheck="false">
                            </b-form-input>
                        </b-form-group>

                        <b-form-group label="Subject"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <b-form-input name="subject" v-model="subject" rows="2"
                                          maxlength="2000"
                                          spellcheck="false">
                            </b-form-input>
                        </b-form-group>
                        <b-form-group label="Tên công ty"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="company_id"
                                    v-model="company_id">
                                <option value="">---</option>
                                <option v-for="company in vars.company"
                                        :value="company.id">
                                    {{company.name}}
                                </option>
                            </select>
                        </b-form-group>
                        <b-form-group label="Select with value"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <select class="custom-select" name="column_select_with_values"
                                    v-model="column_select_with_values">
                                <option value="">---</option>
                                <option v-for="request_report_field in vars.request_report_fields"
                                        :value="request_report_field.key">
                                    {{request_report_field.name}}
                                </option>
                            </select>
                        </b-form-group>
                        <b-form-group label="Value"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <b-form-textarea name="select_with_values" v-model="select_with_values" rows="2"
                                             maxlength="2000"
                                             spellcheck="false"
                                             placeholder="value">
                            </b-form-textarea>
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" class="text-right">
                        <input type="hidden" name="_token" :value="token">
                        <b-button type="submit" variant="primary" class="border-0 main-button mt-3">Run report
                        </b-button>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </b-form>
</template>

<script>
    export default {
        name: "RequestReport",
        props: ['vars'],
        data() {
            return {
                date_range: 2,
                subject: '',
                request_id: '',
                tac_number: '',
                sla: '',
                client_email: '',
                company_id: '',
                priority_id: '',
                from_date: '',
                from_time: '',
                to_date: '',
                to_time: '',
                format: 'HH:mm DD/MM/YYYY',
                lang: {
                    default: 'en'
                },
                status: 'All',
                overdue_status: 'All',
                selectedLocations: [],
                sort_by: 0,
                sort_type: 'asc',
                column_select_with_values: '',
                select_with_values: '',
                token: '',
                request_by: '',
                technician_id: ''
            }
        },
        created: function () {
            this.token = document.querySelector('meta[name="token"]').content
            this.vars.request_report_fields.forEach(function (item) {
                if (parseInt(item.default) === 1) {
                    this.selectedLocations.push(item.key)
                }
            }.bind(this))
        }
    }
</script>

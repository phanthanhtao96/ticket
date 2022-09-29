<template>
    <div>
        <b-form-group label="SLA (*)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <select class="custom-select" name="sla_id" v-model="sla_id" @change="select_sla">
                <option v-for="sla in sla_list" :value="sla.id">
                    {{sla.name}}
                </option>
            </select>
        </b-form-group>
        <b-form-group label="Priority (*)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <select class="custom-select" name="" v-model="priority_id" disabled>
                <option v-for="priority in priorities" :value="priority.id">
                    {{priority.name}}
                </option>
            </select>
            <input type="hidden" name="priority_id" :value="priority_id">
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "RequestSLA",
        props: ['vars'],
        data() {
            return {
                sla_id: this.vars.sla_id || 0,
                priority_id: this.vars.priority_id || 0,
                sla_list: this.vars.sla_list || [],
                priorities: this.vars.priorities || []
            }
        }, methods: {
            select_sla: function () {
                this.sla_list.forEach(function (sla) {
                    if (sla.id === this.sla_id && sla.priority_id !== 0)
                        this.priority_id = sla.priority_id
                }.bind(this))
            }
        }
    }
</script>
<template>
    <div>
        <b-form-group label="Country"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <b-form-select name="country" v-model="country" @change="select_country">
                <option v-for="(name, key) in countries" :value="key">{{name}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="City"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <b-form-select v-if="current_cities" name="city" v-model="city" @change="select_city">
                <option v-for="city in current_cities" :value="city">{{city}}</option>
            </b-form-select>
            <b-form-input type="text" v-if="!current_cities" name="city" v-model="city" value="" minlength="10"
                          maxlength="40" required>
            </b-form-input>
        </b-form-group>
        <b-form-group label="State"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <b-form-select v-if="current_states" name="state" v-model="state">
                <option v-for="state in current_states" :value="state">{{state}}</option>
            </b-form-select>
            <b-form-input type="text" v-if="!current_states" name="state" v-model="state" value="" minlength="10"
                          maxlength="40" required>
            </b-form-input>
        </b-form-group>
        <b-form-group label="Postcode"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <b-form-input type="text" name="postcode" v-model="postcode"
                          minlength="2" maxlength="20" required>
            </b-form-input>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "ClientFrm",
        props: ['client'],
        data() {
            return {
                country: this.client.country ? this.client.country : 'VN',
                city: this.client.city ? this.client.city : 'Hà Nội',
                state: this.client.state ? this.client.state : 'Ba Đình',
                postcode: this.client.postcode,
                current_cities: null,
                current_states: null,
            }
        },
        created: function () {
            this.current_cities = this.cities[this.country] ? this.cities[this.country] : null
            this.current_states = this.states[this.city] ? this.states[this.city] : null
            this.postcode = this.postal_codes[this.city] ? this.postal_codes[this.city] : ''
            console.log(1);
        },
        methods: {
            select_country: function (country) {
                if (this.cities[country]) {
                    this.current_cities = this.cities[country]
                    this.city = this.current_cities[0]
                    this.input_postal_code(this.city)
                    this.select_city(this.city)
                } else {
                    this.city = this.state = this.postcode = ''
                    this.current_cities = null
                    this.current_states = null
                }
            },
            select_city: function (city) {
                if (this.states[city]) {
                    this.current_states = this.states[city]
                    this.state = this.current_states[0]
                    this.input_postal_code(city)
                } else {
                    this.current_states = null
                }
            },
            input_postal_code: function (city) {
                this.postcode = this.postal_codes[city] ? this.postal_codes[city] : ''
            }
        }
    }
</script>
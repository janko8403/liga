<template>
    <div class="row">
        <div class="col-md-12 col-lg-6 offset-lg-3">
            <div class="map">
                <img src="/img/map.png">
                <template v-for="(item, i) in cities" :key="item.id">
                    <div class="box-city" :class="item.city_class" data-bs-target="#moj-zespol" data-bs-toggle="modal">
                        {{ item.city}}
                    </div>
                </template>

            </div>
        </div>
    </div>

    <Modal
        id="moj-zespol"
        title="Mój zespół"
        team
    >
    </Modal>

</template>

<script>
    import Modal from '../subcomponents/Modal'
    import axios from 'axios'
    export default {
        props: {
            section: {}
        },
        components: {
            Modal
        },
        data() {
            return {
                cities: [],
                people: [],
            }
        },
        created() {
            this.getCity()
        },
        methods: {
            async getCity() {
                const response = await axios.get('/api/cities')
                this.cities = response.data
            },
            async getPeople() {
                const response = await axios.get('/api/cities/people')
                this.people = response.data
            }
        }
    }
</script>

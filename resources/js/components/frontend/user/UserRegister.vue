x<template>
    <div class="container">

        <div class="row">
            <div class="col">
                <Alert
                    icon_lg='icon_h'
                    title_lg='Dokończ proces rejestracji'
                >
                </Alert>
                <div class="card-results">
                    <h1>Profil użytkownika</h1>

                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <img class="pt-5 pb-4 avatar-profile" src="/img/avatarmaker2.png">
                                <p class="mt-5 pt-3 pb-5"><a class="btn-pzu btn-pzu_blue-border" href="">dodaj zdjęcie profilowe</a></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="floating-label">
                                    <span class="floating-input" v-html="user.name"></span>
                                    <span class="highlight"></span>
                                    <label>Imię</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="floating-label">
                                    <span class="floating-input" v-html="user.lastname"></span>
                                    <span class="highlight"></span>
                                    <label>Nazwisko</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="floating-label">
                                    <span class="floating-input" v-html="user.email"></span>
                                    <span class="highlight"></span>
                                    <label>E-mail</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="floating-label">
                                    <span class="floating-input" v-html="user.mobile"></span>
                                    <span class="highlight"></span>
                                    <label>Telefon</label>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-5">
                            <div class="col-md-6">
                                <label class="checkboxcontainer"> Oświadczam, że zapoznałem się z Regulaminem i Polityką "Liga Mistrzów" i akceptuję ich postanowienia.
                                    <input type="checkbox" v-model="agreementCheckbox" checked>
                                    <span class="checkmark checkmark_active"></span>
                                </label>

                               <button type="submit" v-if="agreementCheckbox" class="btn-pzu btn-pzu_blue mt-5">DOKOŃCZ REJESTRACJĘ</button>

                               <p class="pt-5">Jeżeli masz jakieś pytania skontaktuj się ze swoim koordynatorem lub napisz na adres <a href="mailto:mampytanie@ligamistorzowbsr.pl">mampytanie@ligamistorzowbsr.pl</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import BreadCrumb from '../../../components/frontend/subcomponents/BreadCrumb'
    import Alert from '../../../components/frontend/subcomponents/Alert'
    import useCMS from "../../../composables/frontend/cms";
    import {onMounted} from "vue";

    export default {
        components: {
            BreadCrumb,
            Alert
        },
        setup() {
            const {user, getUserData} = useCMS()
            onMounted(() => getUserData())

            let agreementCheckbox = ref(false);

            return {
                user,
                agreementCheckbox,
            }
        },
    }
</script>

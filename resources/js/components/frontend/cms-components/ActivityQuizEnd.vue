<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="activity-box">
                    <div class="activity-box_content">
                        <div class="row pt-5 pb-5">
                            <div class="col-12 col-md-12">
                                <div class="title-header">QUIZ Pakiety dodatkowe PNŻ</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card-results">

                    <div class="row">
                        <div class="col-md-12 col-lg-6 offset-lg-3">
                            <div class="icon-font icon-font_no_content icon-color_g text-center pt-5 pb-5">b</div>
                            <h2 class="text-center">Gratulujemy!</h2>
                            <p class="text-center pt-4">Quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid
                                ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam
                                nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>

                            <p class="text-center pt-4"><span>12</span> Ilość poprawnie udzielonych odpowiedzi</p>
                            <p class="text-center pt-4"><span>60 sek.</span> Czas odpowiedzi</p>
                            <p class="text-center pt-4"><span>56%</span> Poprawności odpowiedzi</p>

                            <p class="text-center mt-5 pt-5 mb-5"><a class="btn-pzu btn-pzu_blue" href="/zadania-specjalne">Wróć do zadań specjalnych</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card-results">

                    <div class="row">
                        <div class="col-md-12 col-lg-6 offset-lg-3">
                            <div class="icon-font icon-font_no_content icon-color_g text-center pt-5 pb-5">a</div>
                            <h2 class="text-center">Niestety nie udało sie!!</h2>
                            <p class="text-center pt-4">Quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut
                                aliquid
                                ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                                quam
                                nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>

                            <p class="text-center pt-4"><span>12</span> Ilość poprawnie udzielonych odpowiedzi</p>
                            <p class="text-center pt-4"><span>120 sek.</span> Czas odpowiedzi</p>
                            <p class="text-center pt-4"><span class="span_red">2%</span> Poprawności odpowiedzi</p>

                            <p class="text-center mt-5 pt-5 mb-5"><a class="btn-pzu btn-pzu_blue" href="/zadania-specjalne">Wróć
                                    do zadań specjalnych</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Accordion from '../subcomponents/Accordion'

export default {
    components: {
        Accordion
    }
}
</script>

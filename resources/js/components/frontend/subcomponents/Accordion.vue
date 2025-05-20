<template>
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header" :id="id">
                <button
                    class="accordion-button"
                    :class="{ collapsed: !show}"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="`#collapse-${id}`"
                    aria-expanded="true"
                    :aria-controls="`collapse-${id}`"
                >
                    {{name}}
                </button>
            </h2>
            <div
                class="accordion-collapse collapse"
                :class="{ show: show }"
                :id="`collapse-${id}`"
                :aria-labelledby="`${id}`"
            >
                <div class="accordion-body">
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. </p>

                        <p class="pt-3">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>

                        <ul class="list pt-3">
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                        </ul>

                        <p class="pt-4">
                            <a class="text-decoration-none" href="/">
                                <div class="icon-font icon-color_g icon_u icon-font_lg">Regulamin.pdf</div>
                            </a>
                        </p>
                    </div>


                    <div v-if="content">
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,
                            eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                            voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                            voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci
                            velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. </p>

                            <table class="standard">
                                <thead>
                                    <tr>
                                        <td>Miejsce</td>
                                        <td>Liczba punktów</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Miejsce 1-10</td>
                                        <td>53</td>
                                    </tr>
                                    <tr>
                                        <td>Miejsce 11-20</td>
                                        <td>53</td>
                                    </tr>
                                    <tr>
                                        <td>Miejsce 21-30</td>
                                        <td>53</td>
                                    </tr>
                                    <tr>
                                        <td>Miejsce 31-40</td>
                                        <td>53</td>
                                    </tr>
                                    <tr>
                                        <td>Miejsce 41-50</td>
                                        <td>53</td>
                                    </tr>
                                    <tr>
                                        <td>Pozostałe miejsca</td>
                                        <td>53</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>

                </div>
            </div>
        </div>
</template>

<script>
    export default {
        components: {
        },
        props: {
            id: Number,
            name: String,
            show: Boolean,
            map: Boolean,
            content: Boolean
        }
    }
</script>

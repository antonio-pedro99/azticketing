<!-- resources/views/helpdesk.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('azticketing.app.page_title') }}</title>
    <!-- Add Vuetify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.5.10/dist/vuetify.min.css" rel="stylesheet">

    <!-- Add Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .chip-inline {
            display: inline-flex;
            width: auto;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div id="app">
        <v-app>
            <v-container fluid>
                <v-spacer></v-spacer>
                <v-row>
                    <!-- Left List Section -->
                    <v-col cols="3">
                        <v-card-title>Your tickers </v-card-title>
                        <v-list>
                            <v-list-item v-for="item in items" :key="item.title" @click="selectedItem = item">
                                <v-list-item-content>
                                   <v-card></v-card>
                                        <v-card-title>@{{ item.title }}</v-card-title>
                                        <v-card-text>
                                            <v-chip v-for="tag in item.tags" :key="tag" class="chip-inline"
                                                color="primary" text-color="white">
                                                @{{ tag }}
                                            </v-chip>
                                            <v-chip :color="getStatusColor(item.status)" text-color="white">
                                                @{{ item.status }}
                                            </v-chip>
                                        </v-card-text>
                                    </v-card>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-col>

                    <v-col cols="6" justify="end">
                        <!-- Right Top Section -->
                        <v-card v-if="selectedItem">
                            <v-card-title>@{{ selectedItem.title }}</v-card-title>
                            <v-card-text>
                                <v-form>
                                    <v-chip v-for="tag in selectedItem.tags" :key="tag" class="chip-inline"
                                        color="primary" text-color="white">
                                        @{{ tag }}
                                    </v-chip>

                                    <v-chip :color="getStatusColor(selectedItem.status)" text-color="white">
                                        @{{ selectedItem.status }}
                                    </v-chip> <br><br>

                                    <strong>Description</strong>

                                    <p>@{{ selectedItem.description }}</p>

                                    <strong>Discussion</strong>
                                    <v-textarea label="Add a comment"></v-textarea>
                                    <v-row justify="end">
                                        <v-btn color="primary">Send</v-btn>
                                    </v-row>
                                </v-form>

                                <v-btn @click="selectedItem = null">Back</v-btn>
                            </v-card-text>
                        </v-card>

                        <!-- Right Form Section -->
                        <v-card v-if="selectedItem==null">
                            <v-card-title>Create New Ticket</v-card-title>
                            <v-card-text>
                                <v-form @submit.prevent="submitTicket">
                                    <v-text-field v-model="ticket.title" label="Title" required></v-text-field>

                                    <v-textarea v-model="ticket.description" label="Description" required></v-textarea>

                                    <v-combobox v-model="ticket.tags" label="Tags" multiple chips></v-combobox>

                                    <v-btn type="submit" color="primary">Enviar</v-btn>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="3" v-if="selectedItem">
                        <!-- Right Bottom Section -->
                        <v-card>
                            <v-card-title>Comments</v-card-title>
                            <v-card-text>
                                <v-list>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>Comment 1</v-list-item-title>
                                            <v-list-item-subtitle>Author</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>Comment 2</v-list-item-title>
                                            <v-list-item-subtitle>Author</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                        </v-card>
                </v-row>
            </v-container>
        </v-app>
    </div>

    {{-- <v-snackbar v-model="snackbar" color="success">
        Ticket created successfully!
        <v-btn text @click="snackbar = false">Close</v-btn>
    </v-snackbar>

    <v-snackbar v-model="snackbar" color="error">
        Error creating ticket!
        <v-btn text @click="snackbar = false">Close</v-btn>
    </v-snackbar> --}}

    <!-- Add Vue and Vuetify JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.5.10/dist/vuetify.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data: {
                items: @json($tickets ?? []),
                selectedItem: null,
                ticket: {
                    title: "",
                    description: "",
                    tags: []
                },
                snackbar: false
            },
            methods: {
                submitTicket() {
                    console.log(this.ticket);

                    axios.post('{{ route('azticketing.create') }}', this.ticket)
                        .then(response => {
                            //console.log(response.data);
                            this.items.push(response.data);
                            this.ticket = {
                                title: "",
                                description: "",
                                tags: [],
                            };
                            this.snackbar = true;

                        })
                        .catch(error => {
                            console.error(error);
                            this.snackbar = false;
                        });
                },
                getStatusColor(status) {
                    switch (status) {
                        case 'Doing':
                            return 'blue';
                        case 'Done':
                            return 'green';
                        case 'To Do':
                            return 'orange';
                        default:
                            return 'grey';
                    }
                }
            },
        });
    </script>
</body>

</html>

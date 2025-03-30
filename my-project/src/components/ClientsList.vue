<template>
    <div>
        <form class="flex flex-row justify-center items-center" @submit.prevent="searchClient">
            <input  class="text-sm text-gray-base py-5 px-4 border border-gray-200 rounded" type="text" v-model="customerName" placeholder="Ügyfél neve" />
            <input  class="text-sm text-gray-base py-5 px-4 border border-gray-200 rounded" type="text" v-model="documentId" placeholder="Ügyfél okmányazonosítója" />
            <button class="px-5 bg-green-400 ml-5" type="submit">Keresés</button>
        </form>
    </div>

    <div v-if="clientDetails" class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Ügyfél Részletek</h3>
        <div class="space-y-2">
            <p class="flex"><span class="font-medium w-64">Ügyfél Azonosító:</span> <span>{{ clientDetails.id }}</span></p>
            <p class="flex"><span class="font-medium w-64">Ügyfél Neve:</span> <span>{{ clientDetails.name }}</span></p>
            <p class="flex"><span class="font-medium w-64">Ügyfél Okmányazonosítója:</span> <span>{{ clientDetails.card_name }}</span></p>
            <div class="border-t border-gray-200 my-3 pt-3">
                <p class="flex"><span class="font-medium w-64">Autók Darabszáma:</span> <span>{{ clientDetails.cars_count }}</span></p>
                <p class="flex"><span class="font-medium w-64">Összes Szerviznapló Bejegyzések Száma:</span> <span>{{ clientDetails.service_records_count }}</span></p>
            </div>
        </div>
    </div>

    <div>
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-300">Azonosító</th>
                <th class="px-4 py-2 border border-gray-300">Név</th>
                <th class="px-4 py-2 border border-gray-300">Okmányazonosító</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="client in clients" :key="client.id">
                <td class="px-4 py-2 border border-gray-300">{{ client.id }}</td>
                <td class="px-4 py-2 border border-gray-300">
                    <p
                        class="cursor-pointer text-cyan-500 underline"
                        @click="fetchCars(client.id) && handleClientClick()"
                    >
                        {{ client.name }}
                    </p>
                    <!-- Beágyazott autók táblázat -->
                    <tr v-if="selectedClientId === client.id && selectedClientCars.length > 0">
                        <td colspan="3" class="px-4 py-2 border border-gray-300" style="background-color: #f9f9f9;">
                            <div class="client-details-container">
                                <h2 class="text-xl font-semibold mt-6">Autók: {{ client.name }}</h2>
                                <table class="min-w-full table-auto border-collapse border border-gray-300">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300">Autó azonosító</th>
                                        <th class="px-4 py-2 border border-gray-300">Típus</th>
                                        <th class="px-4 py-2 border border-gray-300">Regisztráció időpontja</th>
                                        <th class="px-4 py-2 border border-gray-300">Sajátmárkás</th>
                                        <th class="px-4 py-2 border border-gray-300">Balesetek</th>
                                        <th class="px-4 py-2 border border-gray-300">Szervíz neve</th>
                                        <th class="px-4 py-2 border border-gray-300">Szervíz dátuma</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="car in selectedClientCars" :key="car.id">
                                        <td class="px-4 py-2 border border-gray-300">
                                            <p
                                                class="cursor-pointer text-cyan-500 underline"
                                                @click="fetchServiceLogs(car.car_id, client.id) && handleCarClick()">
                                                {{ car.car_id }}
                                            </p>

                                            <tr v-if="selectedCarId === car.id && selectedClientId === client.id && carClick">

                                            <td colspan="3" class="px-4 py-2 border border-gray-300" style="background-color: #f9f9f9;">
                                                    <div class="client-details-container">
                                                        <h2 class="text-xl font-semibold mt-6">Services: {{ car.id }}</h2>
                                                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                                                            <thead>
                                                            <tr>
                                                                <th class="px-4 py-2 border border-gray-300">Szervíz alkalom</th>
                                                                <th class="px-4 py-2 border border-gray-300">Esemény neve</th>
                                                                <th class="px-4 py-2 border border-gray-300">Esemény időpontja</th>
                                                                <th class="px-4 py-2 border border-gray-300">Munkalap azonosító</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="log in selectedCarServiceLogs" :key="log.id">
                                                                <td class="px-4 py-2 border border-gray-300">{{ log.lognumber }}</td>
                                                                <td class="px-4 py-2 border border-gray-300">{{ log.event_name }}</td>
                                                                <td class="px-4 py-2 border border-gray-300">{{ log.date === null ? car.registered : log.date }}</td>
                                                                <td class="px-4 py-2 border border-gray-300">{{ log.work_order_id }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                        </td>
                                        <td class="px-4 py-2 border border-gray-300">{{ car.type }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ car.registered }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ car.ownbrand ? 'Igen' : 'Nem' }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ car.accident }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ LatestBiggestLognumberedEventName }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ LatestBiggestLognumberedEventDate }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                </td>
                <td class="px-4 py-2 border border-gray-300">{{ client.card_name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import { useToast } from 'vue-toastification';
import axios from '../axios';

export default defineComponent({
    data() {
        return {
            clients: [],
            selectedClientCars: [],
            selectedClientName: '',
            selectedCarServiceLogs: [],
            selectedClientId: null,
            selectedCarId: null,
            selectedCarRegistered: false,
            LatestBiggestLognumberedEventName: null,
            LatestBiggestLognumberedEventDate: null,
            latestLogData: {},

            customerName: '',
            documentId: '',
            errorMessage: '',
            clientDetails: null,
            carClick: false,



        };
    },
    mounted() {
        this.fetchClients();
    },
    methods: {
        async fetchClients() {
            try {
                const response = await axios.get('/clients');
                this.clients = response.data;
            } catch (error) {
                console.error("Error fetching clients:", error);
            }
        },

        async fetchCars(clientId) {
            const toast = useToast();
            try {
                const response = await axios.get(`clients/${clientId}/cars`);
                const selectedClient = this.clients.find(client => client.id === clientId);


                this.selectedCarServiceLogs = [];
                this.selectedCarId = null;


                this.selectedClientCars = response.data;
                this.selectedClientId = clientId;
                this.selectedClientName = selectedClient.name;


                if (this.selectedClientCars.length > 0) {

                    const firstCarId = this.selectedClientCars[0].car_id;
                    await this.fetchServiceLogs(firstCarId, clientId);
                }
                else {
                    toast.info(`Nincs autója ennek az ügyfélnek: ${this.selectedClientName}`);
                }

            } catch (error) {
                console.error("Error fetching cars:", error);
            }
        },

        async fetchServiceLogs(carId, clientId) {
            try {
                const response = await axios.get(`clients/${clientId}/cars/${carId}/servicelogs`);

                this.selectedCarId = response.data.car.id;
                this.selectedCarServiceLogs = response.data.service_logs || [];

                // Ha nincsenek szerviznaplók, kezeljük az üzenetet
                if (response.data.message) {
                    console.warn(response.data.message);  // Logoljuk a választ
                    this.LatestBiggestLognumberedEventName = response.data.message;
                    this.LatestBiggestLognumberedEventDate = "-";
                } else if (this.selectedCarServiceLogs.length > 0) {
                    // Megkeressük a legnagyobb lognumber értéket
                    const maxLog = this.selectedCarServiceLogs.reduce((max, log) =>
                        log.lognumber > max.lognumber ? log : max
                    );
                    this.LatestBiggestLognumberedEventName = maxLog.event_name;
                    this.LatestBiggestLognumberedEventDate = maxLog.date;
                } else {
                    this.LatestBiggestLognumberedEventName = "Nincs elérhető adat";
                    this.LatestBiggestLognumberedEventDate = "-";
                }
            } catch (error) {
                console.error("Error fetching service logs:", error);
            }
        },

        searchClient() {
            const toast = useToast();
            this.errorMessage = '';
            this.clientDetails = null;

            // Kliens oldali validáció
            if (!this.customerName && !this.documentId) {
                this.errorMessage = 'A kereséshez legalább az egyik mezőt ki kell tölteni!';
                toast.error(this.errorMessage); // Hibaüzenet
                return;
            }

            if (this.customerName && this.documentId) {
                this.errorMessage = 'Csak az egyik mező tölthető ki!';
                toast.error(this.errorMessage); // Hibaüzenet toast
                return;
            }

            // Okmányazonosító validáció
            if (this.documentId && !/^[a-zA-Z0-9]+$/.test(this.documentId)) {
                this.errorMessage = 'Az okmányazonosító csak betűkből és számokból állhat!';
                toast.error(this.errorMessage); // Hibaüzenet toast
                return;
            }

            
            this.fetchClient();
        },

        async fetchClient() {
            const toast = useToast();
            try {
                const response = await axios.get('/searchClients', {
                    params: {
                        name: this.customerName,
                        document_id: this.documentId
                    }
                });


                
                if (response.data.message) {
                    this.errorMessage = 'Több ügyfél találatot találtunk. Kérjük, pontosítson!';
                    toast.warning(this.errorMessage); 
                } else if (response.data.length === 1) {
                    toast.success('Sikeres keresés!'); 
                    this.clientDetails = response.data[0];
                } else {
                    this.errorMessage = 'Nincs találat.';
                    toast.info(this.errorMessage); 
                }
            } catch (error) {
                console.error(error);
                this.errorMessage = 'Hiba történt a keresés során.';
                toast.error(this.errorMessage); 
            }
        },

        handleCarClick(){
            this.carClick = !this.carClick
        },
        handleClientClick(){
            this.carClick = false
        }





    },
});
</script>

<style scoped>
</style>

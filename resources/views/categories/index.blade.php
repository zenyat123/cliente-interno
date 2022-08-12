

<x-app-layout>

	<x-slot name="header">

        <h2 class = "font-semibold text-xl text-gray-800 leading-tight">Categorías</h2>

    </x-slot>

    <div id = "app">

	    <x-container class="py-8">

			<x-form-section v-if="categories.length > 0">

				<x-slot name="title">Lista de categorías</x-slot>

				<x-slot name="description">Actuales junto a sus acciones</x-slot>

				<div>

					<table class = "w-full text-gray-600">

                        <thead class = "border-b border-gray-300">

                            <th class = "py-2">Categoría</th>
                            <th class = "py-2">Url</th>
                            <th class = "py-2">Acciones</th>

                        </thead>

                        <tbody class = "divide-y divide-gray-300">

                            <tr v-for = "category in categories">

                                <td class = "capitalize py-2">@{{ category.category }}</td>

                                <td class = "py-2">@{{ category.url }}</td>

                                <td class = "flex divide-x divide-gray-300 py-2">

                                    <a v-on:click = "edits(category)" class = "cursor-pointer font-semibold hover:text-green-600 pr-2">Actualizar</a>

                                    <a v-on:click = "destroy(category)" class = "cursor-pointer font-semibold hover:text-red-600 pl-2">Eliminar</a>

                                </td>

                            </tr>

                        </tbody>

                    </table>

				</div>

			</x-form-section>

            <x-form-section class="mt-8">

                <x-slot name="title">Registrar categoría</x-slot>

                <x-slot name="description">Ingresar los campos solicitados</x-slot>

                <div class = "grid grid-cols-6 gap-6">

                    <div class = "col-span-6 sm:col-span-4">

                        <x-label>Categoría</x-label>

                        <x-input type="text" v-model="create.category" class="w-full mt-1"/>

                    </div>

                    <div class = "col-span-6 sm:col-span-4">

                        <x-label>Url</x-label>

                        <x-input type="text" v-model="create.url" class="w-full mt-1"></x-input>

                    </div>

                </div>

                <x-slot name="actions">

                    <x-button v-on:click="save" v-bind:disabled="create.disabled">Registrar</x-button>

                </x-slot>

            </x-form-section>

		</x-container>

        <x-dialog-modal modal="edit.open">

            <x-slot name="title">Actualizar categoría</x-slot>

            <x-slot name="content">

                <div class = "space-y-6">

                    <div>

                        <x-label>Categoría</x-label>

                        <x-input type="text" v-model="edit.category" class="w-full mt-1"/>

                    </div>

                    <div>

                        <x-label>Url</x-label>

                        <x-input type="text" v-model="edit.url" class="w-full mt-1"/>

                    </div>

                </div>

            </x-slot>

            <x-slot name="footer">

                <button
                    v-on:click="update()"
                    v-bind:disabled="edit.disabled"
                    class="inline-flex justify-center bg-gray-800 border border-transparent rounded-md font-medium text-base text-white hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 w-full px-4 py-2 mb-3 sm:w-auto sm:text-sm sm:mt-0 sm:ml-3 sm:mb-0">
                    Actualizar
                </button>

                <button v-on:click="edit.open = false"
                    class="inline-flex justify-center bg-white border border-gray-300 rounded-md font-medium text-base text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full px-4 py-2 sm:w-auto sm:text-sm sm:mt-0 sm:ml-3">
                    Cancelar
                </button>

            </x-slot>

        </x-dialog-modal>

	</div>

	@push("vue")

	<script>

        new Vue({

            el: '#app',

            data: {

            	categories: [],
                create: {
                    category: null,
                    url: null,
                    disabled: false
                },
                edit: {
                    open: false,
                    id: null,
                    category: null,
                    url: null,
                    disabled: false
                }

            },

            mounted() {

                this.getCategories();

            },

            methods: {

            	getCategories() {
             
            		axios.get('https://integrar.pro/api/categories', {
                              headers: {'Accept': 'application/json', 'Authorization' : 'Bearer {{ auth()->user()->token->access_token }}'}})
            		     .then(response => {

            		     	this.categories = response.data.data;

		            });

            	},

                save() {

                    this.create.disabled = true;

                    axios.post('https://integrar.pro/api/categories', this.create, {
                               headers: {'Accept': 'application/json', 'Authorization' : 'Bearer {{ auth()->user()->token->access_token }}'}})
                         .then(response => {

                            this.create.category = null;
                            this.create.url = null;

                            this.getCategories();

                            this.create.disabled = false;

                    });

                },

                edits(category) {

                    this.edit.open = true;

                    this.edit.id = category.id;
                    this.edit.category = category.category;
                    this.edit.url = category.url;

                },

                update() {

                    this.edit.disabled = true;

                    axios.put('https://integrar.pro/api/categories/' + this.edit.id, this.edit, {
                              headers: {'Accept': 'application/json', 'Authorization' : 'Bearer {{ auth()->user()->token->access_token }}'}})
                         .then(response => {

                            this.edit.open = false;

                            this.edit.category = null;
                            this.edit.url = null;

                            this.getCategories();

                            this.edit.disabled = false;

                    });

                },

                destroy(category) {

                    axios.delete('https://integrar.pro/api/categories/' + category.id, {
                                 headers: {'Accept': 'application/json', 'Authorization' : 'Bearer {{ auth()->user()->token->access_token }}'}})
                         .then(response => {

                            this.getCategories();

                    });

                }

            }

        });

    </script>

	@endpush

</x-app-layout>


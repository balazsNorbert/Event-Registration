<template>
    <div class="max-w-3xl mx-auto mt-12">
        <div
            class="bg-white shadow-xl border border-gray-100 rounded-2xl overflow-hidden"
        >
            <form @submit.prevent="submit" class="p-8 space-y-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">
                        Új esemény létrehozása
                    </h1>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-1"
                        >Esemény neve</label
                    >
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="pl. Éves Technológiai Konferencia"
                        class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                        :class="{
                            'border-red-500 ring-red-100': form.errors.name,
                        }"
                    />
                    <div
                        v-if="form.errors.name"
                        class="text-red-500 text-xs mt-1 font-medium italic"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-1"
                        >Leírás</label
                    >
                    <textarea
                        v-model="form.description"
                        placeholder="Írd le az esemény részleteit..."
                        class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                        rows="4"
                    ></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-1"
                            >Esemény dátuma</label
                        >
                        <input
                            v-model="form.event_date"
                            type="datetime-local"
                            class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                            :class="{
                                'border-red-500': form.errors.event_date,
                            }"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-1"
                            >Létszámkorlát</label
                        >
                        <input
                            v-model="form.limit"
                            type="number"
                            placeholder="pl. 50"
                            class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                            :class="{ 'border-red-500': form.errors.limit }"
                        />
                    </div>
                </div>

                <div
                    class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-200"
                >
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2 text-center"
                        >Borítókép</label
                    >
                    <input
                        type="file"
                        @input="form.image = $event.target.files[0]"
                        class="block w-full text-sm text-gray-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    />
                </div>

                <div
                    class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100"
                >
                    <Link
                        :href="route('events.index')"
                        class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 transition duration-200"
                    >
                        Mégse
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="form.processing">Feldolgozás...</span>
                        <span v-else>Esemény létrehozása</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { useForm, Link } from "@inertiajs/vue3";

export default {
    components: { Link },
    data() {
        return {
            form: useForm({
                name: "",
                description: "",
                event_date: "",
                limit: 10,
                image: null,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(route("events.store"));
        },
    },
};
</script>

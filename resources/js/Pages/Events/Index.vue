<template>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">
                Közelgő események
            </h1>
            <Link
                :href="route('events.create')"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow hover:bg-indigo-700 transition"
            >
                + Új esemény
            </Link>
        </div>

        <div
            v-if="$page.props.flash.message"
            class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm animate-bounce"
        >
            {{ $page.props.flash.message }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
                v-for="event in events.data"
                :key="event.id"
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col"
            >
                <div class="h-48 overflow-hidden bg-gray-200">
                    <img
                        v-if="event.image_path"
                        :src="'/storage/' + event.image_path"
                        class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500"
                    />
                    <div
                        v-else
                        class="flex items-center justify-center h-full text-gray-400 italic"
                    >
                        Nincs kép feltöltve
                    </div>
                </div>

                <div class="p-6 flex-grow">
                    <div class="flex items-center justify-between mb-2">
                        <span
                            class="text-xs font-bold uppercase tracking-wider text-indigo-600"
                        >
                            {{
                                new Date(event.event_date).toLocaleDateString(
                                    "hu-HU",
                                )
                            }}
                        </span>
                        <span class="text-xs text-gray-500"
                            >Max {{ event.limit }} fő</span
                        >
                    </div>

                    <h2
                        class="text-xl font-bold text-gray-800 mb-3 line-clamp-1"
                    >
                        {{ event.name }}
                    </h2>
                    <p
                        class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed"
                    >
                        {{ event.description }}
                    </p>
                    <button
                        v-if="
                            event.attendees &&
                            event.attendees.some(
                                (a) =>
                                    Number(a.id) ===
                                    Number($page.props.auth.user?.id),
                            )
                        "
                        disabled
                        class="w-full mb-4 py-2 text-white font-semibold rounded-lg hover:bg-indigo-700 transition bg-indigo-600 cursor-not-allowed ..."
                    >
                        Már jelentkeztél
                    </button>

                    <button
                        v-else-if="event.attendees_count >= event.limit"
                        disabled
                        class="w-full mb-4 py-2 text-white font-semibold rounded-lg hover:bg-indigo-700 transition bg-red-400 cursor-not-allowed ..."
                    >
                        Betelt
                    </button>

                    <button
                        v-else
                        @click="register(event.id)"
                        class="w-full mb-4 py-2 text-white font-semibold rounded-lg hover:bg-indigo-700 transition bg-indigo-600 ..."
                    >
                        Jelentkezem
                    </button>
                </div>

                <div class="p-6 pt-0 flex border-t border-gray-50 gap-2">
                    <Link
                        :href="route('events.edit', event.id)"
                        class="flex-1 text-center py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                    >
                        Szerkesztés
                    </Link>
                    <button
                        @click="deleteEvent(event.id)"
                        class="flex-1 text-center py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition"
                    >
                        Törlés
                    </button>
                </div>
            </div>
        </div>

        <div v-if="events.links.length > 3" class="mt-12 flex justify-center">
            <nav
                class="flex items-center gap-1 shadow-sm bg-white p-2 rounded-xl border border-gray-100"
            >
                <template v-for="(link, k) in events.links" :key="k">
                    <div
                        v-if="link.url === null"
                        class="px-4 py-2 text-sm text-gray-400 border border-transparent"
                        v-html="link.label"
                    ></div>

                    <Link
                        v-else
                        :href="link.url"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 border"
                        :class="
                            link.active
                                ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-100'
                                : 'bg-white text-gray-600 border-transparent hover:border-gray-200 hover:bg-gray-50'
                        "
                    >
                        <span v-html="link.label"></span>
                    </Link>
                </template>
            </nav>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    components: { Link },
    props: {
        events: Object,
    },
    watch: {
        "$page.props.flash.message": {
            handler(newVal) {
                if (newVal) {
                    setTimeout(() => {
                        this.$page.props.flash.message = null;
                    }, 6000);
                }
            },
            immediate: true,
        },
    },
    methods: {
        deleteEvent(id) {
            if (confirm("Biztos hogy törölni szeretnéd?")) {
                this.$inertia.delete(route("events.destroy", id));
            }
        },
        register(eventId) {
            this.$inertia.post(
                route("events.register", eventId),
                {},
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        console.log("Sikerült a jelentkezés!");
                    },
                    onError: (errors) => {
                        console.log("Hiba történt:", errors);
                    },
                },
            );
        },
    },
};
</script>

<script setup>
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
    DialogTitle,
} from "@headlessui/vue";
import { useForm } from "@inertiajs/inertia-vue3";

const emit = defineEmits(["close"]);

defineProps({
    open: Boolean,
});

const form = useForm({
    name: "",
});

function createBoard() {
    form.post(route("boards.store"));
    form.reset();

    emit("close");
}
</script>

<template>
    <TransitionRoot :show="open" as="template" @after-leave="query = ''" appear>
        <Dialog as="div" class="relative z-10" @close="$emit('close')">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <DialogPanel
                        class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
                    >
                        <div class="p-5">
                            <DialogTitle
                                as="h3"
                                class="font-semibold leading-6 text-gray-900"
                            >
                                Create Board
                            </DialogTitle>

                            <form
                                @submit.prevent="createBoard"
                                class="mt-3 space-y-6"
                            >
                                <div>
                                    <label
                                        for="board-name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Name
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            id="board-name"
                                            name="board-name"
                                            type="board-name"
                                            autocomplete="board-name"
                                            required=""
                                            v-model="form.name"
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                    <small
                                        class="mt-1 text-red-500"
                                        v-if="form.errors.name"
                                    >
                                        {{ form.errors.name }}
                                    </small>
                                </div>

                                <div>
                                    <button
                                        type="submit"
                                        class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    >
                                        Create
                                    </button>
                                </div>
                            </form>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

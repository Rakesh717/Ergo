<script setup>
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ref } from "vue";
import { format, parseISO } from "date-fns";

const emit = defineEmits(["close", "select"]);

const props = defineProps({
    task: Object,
    open: Boolean,
    value: String,
});

const value = ref(props.value ? formatDueDate(props.value) : "");

const error = ref(null);

function resolveDate() {
    error.value = null;

    if (!value.value) return Promise.resolve();

    return fetch("/api/nlp-calendar", {
        method: "POST",
        body: JSON.stringify({ value: value.value }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            value.value = formatDueDate(data.date);
        })
        .catch(() => {
            error.value = "The given prompt is invalid.";
        });
}

function done() {
    resolveDate().then(() => {
        if (error.value) return;

        emit("select", value.value);
        emit("close");
    });
}

function formatDueDate(date) {
    return format(parseISO(date), "MMMM do, yyyy h:mm a");
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
                            <form @submit.prevent="resolveDate">
                                <label
                                    for="due_date"
                                    class="block text-sm font-semibold text-gray-700"
                                >
                                    Enter Due Date
                                </label>

                                <div class="relative mt-1 flex items-center">
                                    <input
                                        type="text"
                                        name="due_date"
                                        id="due_date"
                                        class="block w-full rounded-md border-gray-300 pr-12 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        v-model="value"
                                        required
                                        @keyup="error = null"
                                    />
                                    <div
                                        class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5"
                                    >
                                        <button
                                            class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400"
                                            type="submit"
                                        >
                                            ↵
                                        </button>
                                    </div>
                                </div>

                                <small class="mt-1 text-red-500" v-if="error">{{
                                    error
                                }}</small>
                            </form>

                            <button
                                type="button"
                                class="mt-3 w-full rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                @click.prevent="done"
                            >
                                Done
                            </button>

                            <div class="text-gray-500 text-sm mt-5">
                                <p class="font-bold">
                                    You prompts like below and press enter
                                </p>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Tomorrow</li>
                                    <li>Tomorrow 6 PM</li>
                                    <li>Next Thursday</li>
                                    <li>First Sunday of this month</li>
                                </ul>
                            </div>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

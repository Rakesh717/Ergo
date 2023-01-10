<script setup>
import SelectMember from "./SelectMember.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import DateTimePicker from "./DateTimePicker.vue";
import { format, parseISO } from "date-fns";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    task: Object,
    members: Array,
});

const selectMember = ref(false);
const showDateTimePicker = ref(false);

function updateAssignee(assignee) {
    useForm({
        assignee_id: assignee ? assignee.id : null,
    }).put(route("tasks.assignee.update", props.task.id));
}

function updateDueDate(date) {
    useForm({
        date,
    }).put(route("tasks.due.update", props.task.id));
}

function formatDueDate(date) {
    date = parseISO(date);

    return format(date, "MMM do, h:mm a");
}

function toggleComplete() {
    if (props.task.is_completed) {
        Inertia.put(route("tasks.mark.uncomplete", props.task.id));
    } else {
        Inertia.put(route("tasks.mark.complete", props.task.id));
    }
}
</script>

<template>
    <Link href="#" class="block bg-white shadow px-4 py-4 rounded-md">
        <div class="flex items-center space-x-2">
            <button
                :class="[
                    task.is_completed
                        ? 'text-green-500 hover:text-green-600'
                        : 'text-gray-500 hover:text-green-500',
                    'transition',
                ]"
                @click.prevent="toggleComplete"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    v-if="!task.is_completed"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    v-else
                >
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                    ></path>
                </svg>
            </button>

            <p>{{ task.title }}</p>
        </div>

        <div class="mt-5 flex justify-between items-center">
            <button
                :class="
                    task.due_at
                        ? ''
                        : 'border-2 border-dashed border-gray-300 rounded-full p-1 text-gray-500 hover:text-gray-700 hover:border-gray-700 transition'
                "
                @click.prevent="showDateTimePicker = true"
            >
                <svg
                    v-if="!task.due_at"
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    ></path>
                </svg>
                <p class="hover:bg-gray-50 rounded-md py-2 px-3" v-else>
                    {{ formatDueDate(task.due_at) }}
                </p>
            </button>

            <button
                :class="[
                    task.assignee
                        ? ''
                        : 'border-2 border-dashed border-gray-300 rounded-full p-1 text-gray-500 hover:text-gray-700 hover:border-gray-700 transition',
                ]"
                @click.prevent="selectMember = true"
            >
                <svg
                    v-if="!task.assignee"
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    ></path>
                </svg>
                <img
                    class="h-8 w-8 object-cover rounded-full"
                    :src="task.assignee.profile_photo_url"
                    :alt="task.assignee.name"
                    v-else
                />
            </button>
        </div>
    </Link>

    <SelectMember
        :show="selectMember"
        :members="members"
        :selected="task.assignee"
        :task="task"
        @select="updateAssignee"
        @close="selectMember = false"
    />

    <DateTimePicker
        :open="showDateTimePicker"
        :value="task.due_at"
        @select="updateDueDate"
        @close="showDateTimePicker = false"
    />
</template>

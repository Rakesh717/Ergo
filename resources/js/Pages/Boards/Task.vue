<script setup>
import SelectMember from "./SelectMember.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
    task: Object,
    members: Array,
});

const emit = defineEmits(["update:task"]);

const selectMember = ref(false);

function updateAssignee(assignee) {
    useForm({
        assignee_id: assignee ? assignee.id : null,
    }).put(route("tasks.assignee.update", props.task.id));
}

function removeAssignee() {
    task.value.assignee = null;
}
</script>

<template>
    <Link href="#" class="block bg-white shadow px-4 py-4 rounded-md">
        <p>{{ task.title }}</p>

        <div class="mt-5 flex justify-between items-center">
            <div class="space-x-3 flex items-center">
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
                <button
                    class="border-2 border-dashed border-gray-300 rounded-full p-1 text-gray-500 hover:text-gray-700 hover:border-gray-700 transition"
                >
                    <svg
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
                </button>
            </div>

            <button class="text-gray-500 hover:text-green-500">
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
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
        @removeSelected="removeAssignee"
    />
</template>

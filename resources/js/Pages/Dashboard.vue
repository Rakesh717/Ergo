<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { formatDistanceToNow, parseISO } from "date-fns";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    tasks: Array,
});

function sectionColor(name) {
    return {
        Todo: "bg-gray-500",
        "In Progress": "bg-yellow-500",
        Complete: "bg-green-500",
    }[name];
}

function taskColor(color) {
    return {
        red: "bg-red-100",
        yellow: "bg-yellow-100",
    }[color];
}
</script>

<template>
    <AppLayout title="My Tasks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
                >
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Task
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Section
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Board
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Due
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-if="tasks.length"
                                v-for="task in tasks"
                                :key="task.id"
                                :class="
                                    task.color ? taskColor(task.color) : null
                                "
                            >
                                <td
                                    class="px-3 py-4 text-sm font-semibold text-gray-700 max-w-[200px]"
                                >
                                    {{ task.title }}
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    <div
                                        class="inline-block text-white text-center py-2 min-w-[120px] px-5 font-semibold"
                                        :class="sectionColor(task.section.name)"
                                    >
                                        {{ task.section.name }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    <Link
                                        href="#"
                                        class="text-indigo-500 font-bold flex items-center space-x-1"
                                    >
                                        <span>
                                            {{ task.section.board.name }}
                                        </span>

                                        <svg
                                            class="w-4 h-4 rotate-45"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18"
                                            ></path>
                                        </svg>
                                    </Link>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-700">
                                    {{
                                        task.due_at
                                            ? formatDistanceToNow(
                                                  parseISO(task.due_at),
                                                  {
                                                      addSuffix: true,
                                                      includeSeconds: true,
                                                  }
                                              )
                                            : "-----"
                                    }}
                                </td>
                            </tr>
                            <tr v-else>
                                <td
                                    class="px-3 py-4 text-sm font-semibold text-gray-500"
                                    colspan="50"
                                >
                                    <p class="text-center">
                                        No uncomplete tasks available...
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

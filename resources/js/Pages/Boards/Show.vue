<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Task from "./Task.vue";

defineProps({
    board: Object,
    members: Array,
});
</script>

<template>
    <AppLayout title="Boards">
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-x-scroll flex gap-x-5">
                    <div
                        class="min-w-[350px]"
                        v-for="section in board.sections"
                        :key="section.id"
                    >
                        <h3 class="text-sm font-semibold">
                            {{ section.name }}
                        </h3>

                        <div
                            class="mt-2 h-[calc(100vh-20vh)] overflow-y-scroll border-gray-300 rounded-md p-1 text-sm space-y-5"
                        >
                            <template
                                v-for="task in section.tasks"
                                :key="task.id"
                            >
                                <Task :members="members" :task="task" />
                            </template>

                            <button
                                class="w-full text-center py-2 bg-gray-50 hover:shadow rounded-md transition"
                            >
                                Add Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
